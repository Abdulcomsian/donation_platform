<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventFrequency;

class EventFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventFrequency = [
            ['title' => 'Monthly'],
            ['title' => 'Quarterly'],
            ['title' => 'Yearly'],
        ];

        EventFrequency::insert($eventFrequency);
    }
}
