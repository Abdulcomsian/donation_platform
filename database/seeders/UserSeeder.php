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
        dd("user created successfully");
    }
}
