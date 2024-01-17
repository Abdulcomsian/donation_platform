<?php

namespace Database\Seeders;

use App\Http\AppConst;
use Illuminate\Database\Seeder;
use App\Models\{User , Address};
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
        $user->save();

        $user->assignRole('fundraiser');

        Address::create([
            'country_id' => 1,
            'city_id' => 1,
            'addressable_id' => $user->id, 
            'addressable_type' => 'App\Models\User',
            'street' => 'st1234'
        ]);

        //another user
        $user1 = new User;
        $user1->first_name = "nouman";
        $user1->last_name = "riaz";
        $user1->email = "nouman@gmail.com";
        $user1->password = Hash::make("nouman123");
        $user1->save();

        $user1->assignRole('admin');

        Address::create([
            'country_id' => 1,
            'city_id' => 2,
            'addressable_id' => $user1->id, 
            'addressable_type' => 'App\Models\User',
            'street' => 'stl56756'
        ]);


        //admin user
        $user2 = new User;
        $user2->first_name = "admin";
        $user2->last_name = "admin";
        $user2->email = "admin@gmail.com";
        $user2->password = Hash::make("admin123");
        $user2->save();

        $user2->assignRole('admin');

        Address::create([
            'country_id' => 2,
            'city_id' => 13,
            'addressable_id' => $user2->id, 
            'addressable_type' => 'App\Models\User',
            'street' => 'stl567678'
        ]);


        //admin user
        $user3 = new User;
        $user3->first_name = "nouman";
        $user3->last_name = "riaz";
        $user3->email = "mnoumanb@gmail.com";
        $user3->password = Hash::make("nouman123");
        $user3->save();

        $user3->assignRole('non_profit_organization');

        Address::create([
            'country_id' => 2,
            'city_id' => 13,
            'addressable_id' => $user->id, 
            'addressable_type' => 'App\Models\User',
            'street' => 'stl567678'
        ]);

        
    }
}
