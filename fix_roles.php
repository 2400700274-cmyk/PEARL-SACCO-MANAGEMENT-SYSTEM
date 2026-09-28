<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$role = \App\Models\Role::where('slug', 'admin')->first();
if ($role) {
    $role->permissions()->sync(\App\Models\Permission::pluck('id'));
    echo "Fixed permissions for admin role.\n";
}
