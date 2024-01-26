<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventCategory;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventCategories = [
            ['title' => 'Health and Medical'],
            ['title' => 'Education'],
            ['title' => 'Disaster Relief'],
            ['title' => 'Community Development'],
            ['title' => 'Animal Welfare'],
            ['title' => 'Environmental Causes'],
            ['title' => 'Arts and Culture'],
            ['title' => 'Social Justice'],
            ['title' => 'Humanitarian Aid'],
            ['title' => 'Religious Organizations'],
            ['title' => 'Sports and Athletics'],
            ['title' => 'Technology and Innovation'],
            ['title' => 'Food and Hunger'],
            ['title' => 'Cancer Research'],
            ['title' => 'Mental Health Awareness'],
            ['title' => 'Veterans and Military Support'],
            ['title' => 'Clean Water and Sanitation'],
            ['title' => 'Empowerment Programs'],
            ['title' => 'Agriculture and Farming'],
            ['title' => 'Legal Aid and Advocacy'],
        ];


        EventCategory::insert($eventCategories);

        
    }
}
