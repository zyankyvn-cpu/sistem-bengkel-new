<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Buat 4 role
        $RoleAdmin   = Role::firstOrCreate(['name' => 'Admin']);
        $RoleKasir   = Role::firstOrCreate(['name' => 'Kasir']);
        $RoleMekanik = Role::firstOrCreate(['name' => 'Mekanik']);
        $RoleOwner   = Role::firstOrCreate(['name' => 'Owner']);

        // Buat user untuk tiap role
       $UserAdmin = User::firstOrCreate(
    ['email' => 'admin@bengkel.com'],
    ['name' => 'Admin Bengkel', 'password' => Hash::make('password')]
);
$UserAdmin->assignRole($RoleAdmin);

$UserKasir = User::firstOrCreate(
    ['email' => 'kasir@bengkel.com'],
    ['name' => 'Kasir Bengkel', 'password' => Hash::make('password')]
);
$UserKasir->assignRole($RoleKasir);

$UserMekanik = User::firstOrCreate(
    ['email' => 'mekanik@bengkel.com'],
    ['name' => 'Mekanik Bengkel', 'password' => Hash::make('password')]
);
$UserMekanik->assignRole($RoleMekanik);

$UserOwner = User::firstOrCreate(
    ['email' => 'owner@bengkel.com'],
    ['name' => 'Owner Bengkel', 'password' => Hash::make('password')]
);
$UserOwner->assignRole($RoleOwner);
    }
}