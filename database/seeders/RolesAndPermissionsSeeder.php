<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Dashboard
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard', 'module' => 'Dashboard'],

            // SACCO Management
            ['name' => 'Manage SACCOs', 'slug' => 'manage-saccos', 'module' => 'SACCOs'],

            // Members
            ['name' => 'View Members', 'slug' => 'view-members', 'module' => 'Members'],
            ['name' => 'Create Members', 'slug' => 'create-members', 'module' => 'Members'],
            ['name' => 'Edit Members', 'slug' => 'edit-members', 'module' => 'Members'],

            // Savings
            ['name' => 'View Savings', 'slug' => 'view-savings', 'module' => 'Savings'],
            ['name' => 'Transact Savings', 'slug' => 'transact-savings', 'module' => 'Savings'],

            // Loans
            ['name' => 'View Loans', 'slug' => 'view-loans', 'module' => 'Loans'],
            ['name' => 'Create Loans', 'slug' => 'create-loans', 'module' => 'Loans'],
            ['name' => 'Approve Loans', 'slug' => 'approve-loans', 'module' => 'Loans'],

            // Repayments
            ['name' => 'Record Repayments', 'slug' => 'record-repayments', 'module' => 'Repayments'],

            // Reports
            ['name' => 'View Reports', 'slug' => 'view-reports', 'module' => 'Reports'],

            // Settings & Staff
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'module' => 'Settings'],
            ['name' => 'Manage Staff', 'slug' => 'manage-staff', 'module' => 'Staff'],

            // Member Portal
            ['name' => 'View Member Dashboard', 'slug' => 'view-member-dashboard', 'module' => 'Member Portal'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['slug' => 'super-admin'], ['name' => 'Super Administrator', 'description' => 'Platform Administrator with master access to all SACCOs']);
        $admin = Role::firstOrCreate(['slug' => 'administrator'], ['name' => 'Administrator', 'description' => 'Full access to individual SACCO workspace']);
        $loanOfficer = Role::firstOrCreate(['slug' => 'loan-officer'], ['name' => 'Loan Officer', 'description' => 'Can manage loans and view members']);
        $cashier = Role::firstOrCreate(['slug' => 'cashier'], ['name' => 'Cashier', 'description' => 'Can transact savings and record loan repayments']);
        $memberRole = Role::firstOrCreate(['slug' => 'member'], ['name' => 'Member', 'description' => 'SACCO Member with access to personal member portal and self-service']);

        // Assign Permissions
        // Super Admin gets all
        $superAdmin->permissions()->sync(Permission::pluck('id'));

        // Member Role gets member dashboard
        $memberRole->permissions()->sync(
            Permission::whereIn('slug', ['view-member-dashboard'])->pluck('id')
        );

        // Admin gets all except manage-saccos (unless granted)
        $admin->permissions()->sync(
            Permission::where('slug', '!=', 'manage-saccos')->pluck('id')
        );

        // Loan Officer
        $loanOfficer->permissions()->sync(
            Permission::whereIn('slug', [
                'view-dashboard', 'view-members', 'view-savings',
                'view-loans', 'create-loans', 'view-reports',
            ])->pluck('id')
        );

        // Cashier
        $cashier->permissions()->sync(
            Permission::whereIn('slug', [
                'view-dashboard', 'view-members', 'view-savings', 'transact-savings',
                'view-loans', 'record-repayments',
            ])->pluck('id')
        );

        // Seed default Platform Super Administrator
        User::firstOrCreate(
            ['email' => 'admin@pearlsacco.org'],
            [
                'name' => 'Pearl System Administrator',
                'nin' => 'CM90012345ABCD',
                'password' => bcrypt('password'),
                'role_id' => $superAdmin->id,
                'status' => 'Active',
            ]
        );

        // Seed default Member User Account if member exists
        if (Member::where('id', 1)->exists()) {
            User::firstOrCreate(
                ['email' => 'member@pearlsacco.org'],
                [
                    'name' => 'Mathew Phillip',
                    'nin' => 'CM90012345ABCD',
                    'password' => bcrypt('password'),
                    'role_id' => $memberRole->id,
                    'status' => 'Active',
                    'member_id' => 1,
                ]
            );
        }
    }
}
