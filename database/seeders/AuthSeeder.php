<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           DB::table('admins')->insert([
            [
                'name' => 'Super Admin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'super@admin.com',
                'password' => Hash::make('password'),
                'type' => 'super_admin',
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at'=>now()
            ],
            [
                'name' => 'Admin User',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'type' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at'=>now()
            ],
        ]);

        // ================= INSTRUCTORS =================
        DB::table('instructors')->insert([
            [
                'first_name' => 'Ahmed',
                'last_name' => 'Ali',
                'name' => 'Ahmed Ali',
                'email' => 'instructor1@test.com',
                'password' => Hash::make('password'),
                'status' => 'active',
                'bio' => 'Senior Web Instructor',
                'day' => 10,
                'month' => 'May',
                'year' => 1995,
                'city' => 'Cairo',
                'country' => 'Egypt',
                'experience' => '5 years Laravel experience',
                'gender' => 'male',
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at'=>now()
            ],
        ]);

        // ================= USERS =================
        DB::table('users')->insert([
            [
                'first_name' => 'Mohamed',
                'last_name' => 'Hassan',
                'name' => 'Mohamed Hassan',
                'email' => 'user@test.com',
                'password' => Hash::make('password'),
                'status' => 'active',
                'bio' => 'Normal user',
                'day' => 15,
                'month' => 'June',
                'year' => 2000,
                'city' => 'Alexandria',
                'country' => 'Egypt',
                'experience' => null,
                'gender' => 'male',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
