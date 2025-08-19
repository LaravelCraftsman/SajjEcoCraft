<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder {
    /**
    * Run the database seeds.
    *
    * @return void
    */

    public function run() {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@sajjecocraft.com',
                'role' => 'admin',
            ],
            [
                'name' => 'customer',
                'email' => 'customer@sajjecocraft.com',
                'role' => 'customer',
            ],
            [
                'name' => 'staff',
                'email' => 'staff@sajjecocraft.com',
                'role' => 'staff',
            ],
            [
                'name' => 'developer',
                'email' => 'developer@sajjecocraft.com',
                'role' => 'developer',
            ],
        ];

        foreach ( $users as $userData ) {
            User::updateOrCreate(
                [ 'email' => $userData[ 'email' ] ],
                [
                    'name' => $userData[ 'name' ],
                    'password' => Hash::make( 'password' ),
                    'role' => $userData[ 'role' ],
                ]
            );
        }
    }
}