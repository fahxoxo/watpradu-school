<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Create test user
$user = User::firstOrCreate(
    ['email' => 'admin@watpradu.ac.th'],
    [
        'name' => 'Admin Watpradu',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]
);

echo "User created/exists: " . $user->email . "\n";
echo "Password: password\n";
?>
