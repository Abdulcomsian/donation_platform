<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PriceOption;

class PriceOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priceOptions = [ 
                ['amount' => 25 ], 
                ['amount' => 50 ] , 
                ['amount' => 100 ] , 
                ['amount' => 500 ]
            ];
        
        PriceOption::insert($priceOptions);

    }
}
