<?php

namespace Database\Seeders;

use App\Http\AppConst;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;
        $user->first_name = "shahbaz";
        $user->last_name = "masood";
        $user->email = "shahbaz@gmail.com";
        $user->password = Hash::make("123456");
        $user->country_id = 1;
        $user->type = AppConst::FUNDRAISER;

        $user->save();

        //another user
        $user1 = new User;
        $user1->first_name = "nouman";
        $user1->last_name = "riaz";
        $user1->email = "nouman@gmail.com";
        $user1->password = Hash::make("nouman123");
        $user1->country_id = 1;
        $user1->type = AppConst::ADMIN;
        $user1->save();


        //admin user
        $user2 = new User;
        $user2->first_name = "admin";
        $user2->last_name = "admin";
        $user2->email = "admin@gmail.com";
        $user2->password = Hash::make("admin123");
        $user2->country_id = 1;
        $user2->type = AppConst::ADMIN;
        $user2->save();


        // dd("user created successfully");
    }
}
