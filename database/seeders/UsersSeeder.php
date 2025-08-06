<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert 5 users into the users table with specific data
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'), // Default password for all users
             
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sam Brown',
                'email' => 'sambrown@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lucy Green',
                'email' => 'lucygreen@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
              
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mark White',
                'email' => 'markwhite@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
              
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
