<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignAdminRoleToFirstUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve the first user from the database
        $user = User::first();

        // Ensure a user exists
        if ($user) {
            // Assign the admin role to the user
            $user->assignRole('admin');
        }
    }
}
