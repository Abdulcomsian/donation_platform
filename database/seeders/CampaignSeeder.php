<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Campaign;
use Faker\Factory as Faker;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

            $campaignList = [];
            $userId = 1;

            for($i =0 ; $i <= 20 ; $i++){

                $campaign = [
                    'title' => $faker->name,
                    'excerpt' => $faker->text(100),
                    'description' => $faker->text(300),
                    'frequency' => $faker->randomElement(['monthly' , 'quarterly' , 'annually']),
                    'recurring'=> $faker->randomElement(['disable' , 'optional' , 'required']),
                    'file' => 'Screenshot_5.png',
                    'date' => $faker->date()
                ];

                $campaign_goal = rand(0,1);

                if($campaign_goal){
                    $campaign2 = [
                        'amount' => $faker->randomFloat(2, 10, 100),
                        'fee_recovery' => $faker->randomFloat(2, 10, 30),
                    ]; 
                    
                    $campaign = array_merge($campaign , $campaign2);
                }else{
                    $campaign2 = [
                        'amount' => null,
                        'fee_recovery' => null,
                    ]; 
                    
                    $campaign = array_merge($campaign , $campaign2);
                }

                $campaignList[] = $campaign;

            }

            Campaign::insert($campaignList);

        }
        
}
