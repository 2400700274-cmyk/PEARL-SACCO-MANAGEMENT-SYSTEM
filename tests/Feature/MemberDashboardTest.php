<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Role;
use App\Models\Sacco;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MemberDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $memberUser;

    protected Member $member;

    protected SavingsAccount $savingsAccount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $memberRole = Role::where('slug', 'member')->firstOrFail();

        // Create a test SACCO Admin / Tenant
        $adminRole = Role::where('slug', 'administrator')->firstOrFail();
        $adminUser = User::factory()->create([
            'role_id' => $adminRole->id,
            'status' => 'Active',
        ]);

        // Create Member
        $this->member = Member::create([
            'user_id' => $adminUser->id,
            'member_number' => 'PSM-2026-0001',
            'name' => 'Kato Paul',
            'nin' => 'CM98765432WXYZ',
            'contact' => 'katopaul@example.com',
            'next_of_kin_name' => 'Nalubega Sarah',
            'next_of_kin_contact' => '+256701234567',
            'next_of_kin_relationship' => 'Spouse',
            'next_of_kin_address' => 'Mukono Town',
            'status' => 'Active',
            'registered_at' => Carbon::now()->subMonths(6),
        ]);

        // Create Member User Account
        $this->memberUser = User::create([
            'name' => 'Kato Paul',
            'email' => 'katopaul@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $memberRole->id,
            'status' => 'Active',
            'parent_id' => $adminUser->id,
            'member_id' => $this->member->id,
        ]);

        // Create Savings Account with initial balance
        $this->savingsAccount = $this->member->savingsAccounts()->create([
            'balance' => 1000000.00,
            'status' => 'Active',
        ]);

        // Record a deposit transaction
        SavingsTransaction::create([
            'savings_account_id' => $this->savingsAccount->id,
            'type' => 'Deposit',
            'amount' => 1000000.00,
            'transaction_date' => Carbon::now()->subMonths(2),
            'description' => 'Initial Savings Deposit',
        ]);
    }

    public function test_member_can_view_dashboard_with_required_metrics_and_next_of_kin(): void
    {
        $response = $this->actingAs($this->memberUser)->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Kato Paul');
        $response->assertSee('PSM-2026-0001');
        $response->assertSee('Active Member');
        // Summary Cards
        $response->assertSee('UGX 1,000,000.00'); // Savings
        $response->assertSee('UGX 3,000,000.00'); // 3x available loan limit
        // Next of Kin (Requirement MD-009)
        $response->assertSee('Nalubega Sarah');
        $response->assertSee('+256701234567');
        $response->assertSee('Spouse');
    }

    public function test_member_login_requires_the_sacco_linked_to_their_account(): void
    {
        $sacco = Sacco::create([
            'admin_id' => $this->member->user_id,
            'name' => 'Kampala Farmers SACCO',
            'status' => 'Active',
        ]);

        $response = $this->from(route('login', ['portal' => 'member']))->post(route('login.post'), [
            'email' => $this->memberUser->email,
            'password' => 'password123',
            'sacco_id' => $sacco->id,
        ]);

        $response->assertRedirect(route('member.dashboard'));
        $this->assertAuthenticatedAs($this->memberUser);
    }

    public function test_member_login_rejects_a_different_sacco_selection(): void
    {
        $otherAdmin = User::factory()->create([
            'role_id' => Role::where('slug', 'administrator')->firstOrFail()->id,
            'status' => 'Active',
        ]);
        $otherSacco = Sacco::create([
            'admin_id' => $otherAdmin->id,
            'name' => 'Other Farmers SACCO',
            'status' => 'Active',
        ]);

        $response = $this->from(route('login', ['portal' => 'member']))->post(route('login.post'), [
            'email' => $this->memberUser->email,
            'password' => 'password123',
            'sacco_id' => $otherSacco->id,
        ]);

        $response->assertRedirect(route('login', ['portal' => 'member']));
        $response->assertSessionHasErrors('sacco_id');
        $this->assertGuest();
    }

    public function test_member_login_rejects_missing_sacco_selection(): void
    {
        $response = $this->from(route('login', ['portal' => 'member']))->post(route('login.post'), [
            'email' => $this->memberUser->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('login', ['portal' => 'member']));
        $response->assertSessionHasErrors('sacco_id');
        $this->assertGuest();
    }

    public function test_member_cannot_view_another_sacco_member_dashboard(): void
    {
        $otherAdmin = User::factory()->create([
            'role_id' => Role::where('slug', 'administrator')->firstOrFail()->id,
            'status' => 'Active',
        ]);
        $otherMember = Member::create([
            'user_id' => $otherAdmin->id,
            'member_number' => 'PSM-2026-0002',
            'name' => 'Other SACCO Member',
            'contact' => 'othermember@example.com',
            'status' => 'Active',
            'registered_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($this->memberUser)->get(route('member.dashboard', [
            'member_id' => $otherMember->id,
        ]));

        $response->assertOk();
        $response->assertSee('Kato Paul');
        $response->assertDontSee('Other SACCO Member');
    }

    public function test_member_cannot_download_another_sacco_loan_statement(): void
    {
        $otherAdmin = User::factory()->create([
            'role_id' => Role::where('slug', 'administrator')->firstOrFail()->id,
            'status' => 'Active',
        ]);
        $otherMember = Member::create([
            'user_id' => $otherAdmin->id,
            'member_number' => 'PSM-2026-0002',
            'name' => 'Other SACCO Member',
            'contact' => 'othermember@example.com',
            'status' => 'Active',
            'registered_at' => Carbon::now(),
        ]);
        $loan = $otherMember->loans()->create([
            'principal_amount' => 400000.00,
            'interest_rate' => 10.00,
            'duration_months' => 4,
            'total_payable' => 440000.00,
            'balance' => 440000.00,
            'status' => 'Active',
            'due_date' => Carbon::now()->addMonths(4),
        ]);

        $response = $this->actingAs($this->memberUser)->get(route('member.loans.statement', [
            'loan' => $loan->id,
            'member_id' => $otherMember->id,
        ]));

        $response->assertNotFound();
    }

    public function test_member_can_filter_savings_records_by_date_range(): void
    {
        // Add another transaction last week
        SavingsTransaction::create([
            'savings_account_id' => $this->savingsAccount->id,
            'type' => 'Deposit',
            'amount' => 250000.00,
            'transaction_date' => Carbon::now()->subDays(5),
            'description' => 'Recent Farming Income',
        ]);

        // Filter for only the recent transaction
        $response = $this->actingAs($this->memberUser)->get(route('member.dashboard', [
            'from_date' => Carbon::now()->subDays(7)->format('Y-m-d'),
            'to_date' => Carbon::now()->format('Y-m-d'),
        ]));

        $response->assertStatus(200);
        $response->assertSee('Recent Farming Income');
        $response->assertDontSee('Initial Savings Deposit');
    }

    public function test_member_can_download_savings_statement_as_csv_and_print(): void
    {
        // CSV Export
        $csvResponse = $this->actingAs($this->memberUser)->get(route('member.savings.statement', [
            'format' => 'csv',
        ]));
        $csvResponse->assertStatus(200);
        $csvResponse->assertHeader('Content-type', 'text/csv; charset=UTF-8');

        // Print/PDF View
        $printResponse = $this->actingAs($this->memberUser)->get(route('member.savings.statement', [
            'format' => 'print',
        ]));
        $printResponse->assertStatus(200);
        $printResponse->assertSee('Member Savings Account Statement');
        $printResponse->assertSee('Kato Paul');
    }

    public function test_member_can_apply_for_loan_online(): void
    {
        // Requirement MD-020
        $response = $this->actingAs($this->memberUser)->post(route('member.loans.apply'), [
            'loan_type' => 'Agricultural Crop Production Loan',
            'requested_amount' => 500000,
            'duration_months' => 6,
            'loan_purpose' => 'Purchasing fertilizer and maize seeds for the planting season',
            'collateral_description' => '1 Dairy Cow',
            'collateral_value' => 800000,
            'guarantor_name' => 'Mukasa John',
            'guarantor_contact' => '+256702223344',
            'guarantor_nin' => 'CM12345678ABCD',
        ]);

        $response->assertRedirect(route('member.dashboard', ['member_id' => $this->member->id]));
        $this->assertDatabaseHas('loans', [
            'member_id' => $this->member->id,
            'loan_type' => 'Agricultural Crop Production Loan',
            'principal_amount' => 500000.00,
            'duration_months' => 6,
            'status' => 'Pending',
        ]);
    }

    public function test_member_can_view_loan_details_schedule_and_overdue_penalties(): void
    {
        // Create an active loan that is overdue
        $dueDate = Carbon::now()->subDays(15);
        $loan = $this->member->loans()->create([
            'loan_type' => 'Livestock & Animal Husbandry Loan',
            'principal_amount' => 600000.00,
            'interest_rate' => 10.00,
            'duration_months' => 3,
            'total_payable' => 660000.00,
            'balance' => 440000.00,
            'penalty_amount' => 25000.00,
            'due_date' => $dueDate,
            'status' => 'Active',
            'approved_at' => Carbon::now()->subMonths(3)->subDays(15),
        ]);

        // Repayment
        $loan->repayments()->create([
            'amount' => 220000.00,
            'paid_at' => Carbon::now()->subMonths(1),
            'status' => 'Completed',
        ]);

        $response = $this->actingAs($this->memberUser)->get(route('member.dashboard'));

        $response->assertStatus(200);
        // Requirement MD-021 & MD-024: loan details
        $response->assertSee('Livestock & Animal Husbandry Loan', false);
        $response->assertSee('UGX 600,000.00'); // Principal
        $response->assertSee('UGX 440,000.00'); // Balance
        $response->assertSee('UGX 220,000.00'); // Amount Paid
        // Requirement MD-026: Repayment schedule
        $response->assertSee('Installment 1');
        $response->assertSee('Installment 2');
        $response->assertSee('Installment 3');
        // Requirement MD-027: Overdue penalties
        $response->assertSee('UGX 25,000.00');
        $response->assertSee('Overdue Penalty Applied');
    }

    public function test_member_can_download_loan_repayment_statement(): void
    {
        // Requirement MD-028
        $loan = $this->member->loans()->create([
            'loan_type' => 'Farm Inputs & Machinery Loan',
            'principal_amount' => 400000.00,
            'interest_rate' => 10.00,
            'duration_months' => 4,
            'total_payable' => 440000.00,
            'balance' => 440000.00,
            'status' => 'Active',
            'due_date' => Carbon::now()->addMonths(4),
        ]);

        $csvResponse = $this->actingAs($this->memberUser)->get(route('member.loans.statement', [
            'loan' => $loan->id,
            'format' => 'csv',
        ]));
        $csvResponse->assertStatus(200);
        $csvResponse->assertHeader('Content-type', 'text/csv; charset=UTF-8');

        $printResponse = $this->actingAs($this->memberUser)->get(route('member.loans.statement', [
            'loan' => $loan->id,
            'format' => 'print',
        ]));
        $printResponse->assertStatus(200);
        $printResponse->assertSee('Official Loan Repayment Statement');
        $printResponse->assertSee('Scheduled Installments');
    }

    public function test_member_can_change_password(): void
    {
        $response = $this->actingAs($this->memberUser)->post(route('member.password.update'), [
            'current_password' => 'password123',
            'new_password' => 'newSecretPass2026',
            'new_password_confirmation' => 'newSecretPass2026',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->memberUser->refresh();
        $this->assertTrue(Hash::check('newSecretPass2026', $this->memberUser->password));
    }
}
