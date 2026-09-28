<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$adminRole = \App\Models\Role::where('slug', 'administrator')->first();
if (!$adminRole) {
    echo "Administrator role not found.\n";
    exit;
}

$users = \App\Models\User::whereNull('role_id')->get();
foreach ($users as $user) {
    $user->update(['role_id' => $adminRole->id]);
    echo "Assigned administrator role to user: " . $user->email . "\n";
}

$adminLegacyRole = \App\Models\Role::where('slug', 'admin')->first();
if ($adminLegacyRole) {
    $legacyUsers = \App\Models\User::where('role_id', $adminLegacyRole->id)->get();
    foreach ($legacyUsers as $user) {
        $user->update(['role_id' => $adminRole->id]);
        echo "Re-assigned legacy admin role to administrator for user: " . $user->email . "\n";
    }
}

echo "Done.\n";
