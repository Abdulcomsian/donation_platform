<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'non_profit_organization'],
            ['name' => 'fundraiser'],
            ['name' => 'admin'],
            ['name' => 'donar'],
            ['name' => 'ticket_purchaser'],
        ];
        Role::insert($roles);
    }
}
