<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Campaign , CampaignFrequency};
use Faker\Factory as Faker;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

            // $userId = User::orderBy('id' , 'asc')->first()->id;

            for($i =0 ; $i <= 20 ; $i++){

                $campaign = [
                    'user_id' => 4,
                    'created_by' => $faker->randomElement([1,2]),
                    'title' => $faker->name,
                    'excerpt' => $faker->text(100),
                    'description' => $faker->text(200),
                    'recurring'=> $faker->randomElement(['disable' , 'optional' , 'required']),
                    'image' => 'Screenshot_5.png',
                    'fee_recovery'=> $faker->randomElement(['disable' , 'optional' , 'required']),
                ];

                $campaign_goal = rand(0,1);

                if($campaign_goal){
                    $campaign2 = [
                        'campaign_goal' => $campaign_goal,
                        'expiry_date' => $faker->date(),
                        'amount' => $faker->randomFloat(2, 10, 100),
                    ]; 
                    
                    $campaign = array_merge($campaign , $campaign2);
                }else{
                    $campaign2 = [
                        'campaign_goal' => $campaign_goal,
                        'amount' => null,
                        'expiry_date' => null,
                    ]; 
                    
                    $campaign = array_merge($campaign , $campaign2);
                }

               $campaignId = Campaign::insertGetId($campaign);

               CampaignFrequency::create([
                                        'campaign_id' => $campaignId,
                                        'type' => $faker->randomElement(['monthly' , 'quarterly' , 'annually']),
                                    ]);
            
               
            }

        }
        
}
