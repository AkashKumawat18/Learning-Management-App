<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
                    //admin
        [
            "name"=> "Admin",
            "email"=> "admin@gmail.com",
            "password"=> Hash::make('111'),
            'role'=>'admin',
            'status'=>'1',
        ],
        [
            "name"=> "Instructor",
            "email"=> "instructor@gmail.com",
            "password"=> Hash::make('111'),
            'role'=>'instructor',
            'status'=>'1'
        ],
           //User data
        [
            "name"=> "User",
            "email"=> "user@gmail.com",
            "password"=> Hash::make('111'),
            'role'=>'user',
            'status'=>'1'
        ],
    ]);

    }
}
