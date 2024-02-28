<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\{CampaignSeeder, 
                        CountrySeeder, 
                        UserSeeder, 
                        RolesSeeder, 
                        MailchimpSeeder,
                        EventCategorySeeder,
                        EventFrequencySeeder,
                    };
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MailchimpSeeder::class);
        $this->call(CampaignSeeder::class);
        $this->call(PlatformPercentageSeeder::class);
        $this->call(EventCategorySeeder::class);
        $this->call(EventFrequencySeeder::class);
    }
}
