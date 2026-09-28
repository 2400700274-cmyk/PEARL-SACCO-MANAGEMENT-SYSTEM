<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Dashboard
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard', 'module' => 'Dashboard'],
            
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
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
        }

        // Roles
        $admin = Role::firstOrCreate(['slug' => 'administrator'], ['name' => 'Administrator', 'description' => 'Full access to all modules']);
        $loanOfficer = Role::firstOrCreate(['slug' => 'loan-officer'], ['name' => 'Loan Officer', 'description' => 'Can manage loans and view members']);
        $cashier = Role::firstOrCreate(['slug' => 'cashier'], ['name' => 'Cashier', 'description' => 'Can transact savings and record loan repayments']);

        // Assign Permissions
        // Admin gets all
        $admin->permissions()->sync(Permission::pluck('id'));

        // Loan Officer
        $loanOfficer->permissions()->sync(
            Permission::whereIn('slug', [
                'view-dashboard', 'view-members', 'view-savings', 
                'view-loans', 'create-loans', 'view-reports'
            ])->pluck('id')
        );

        // Cashier
        $cashier->permissions()->sync(
            Permission::whereIn('slug', [
                'view-dashboard', 'view-members', 'view-savings', 'transact-savings',
                'view-loans', 'record-repayments'
            ])->pluck('id')
        );
    }
}
