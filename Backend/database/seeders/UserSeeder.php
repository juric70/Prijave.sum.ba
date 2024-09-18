<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User; // Uverite se da ste dodali ovu liniju

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'John',
                'lastname' => 'Doe',
                'username' => 'johndoe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane',
                'lastname' => 'Doe',
                'username' => 'janedoe',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Umetanje korisnika u bazu
        foreach ($users as $userData) {
            $user = User::create($userData);

            // Dodeljivanje rola
            if ($user->email === 'john@example.com') {
                $user->assignRole('superAdmin'); // Dodeljuje ulogu 'superAdmin'
            } elseif ($user->email === 'jane@example.com') {
                $user->assignRole('kreator'); // Dodeljuje ulogu 'kreator'
            }
        }
    }
}
