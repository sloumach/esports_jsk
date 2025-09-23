<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@jsk.tn'],
            [
                'first_name' => 'Super',
                'last_name'  => 'Admin',
                'password'   => bcrypt('password123'), // ⚠️ change in prod
                'locale'     => 'fr',
                'status'     => 'active',
            ]
        );

        $role = Role::where('name', 'admin')->first();
        if ($role) {
            $admin->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
