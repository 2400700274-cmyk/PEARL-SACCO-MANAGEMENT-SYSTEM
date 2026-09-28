<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\Models\User::where('email', 'admin@sacco.com')->first();
if (!$user) {
    echo "User not found\n";
    exit;
}

echo 'Role ID: ' . $user->role_id . "\n";
$role = $user->role;
if ($role) {
    echo 'Role Name: ' . $role->name . ' (' . $role->slug . ")\n";
    echo 'Permissions count: ' . $role->permissions()->count() . "\n";
    foreach ($role->permissions as $p) {
        echo " - " . $p->slug . "\n";
    }
} else {
    echo "Role not found for user.\n";
}
