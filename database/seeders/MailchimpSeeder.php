<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{ User , MailchimpIntegration};
use Illuminate\Support\Facades\Crypt;
use MailchimpMarketing\{ ApiClient , ApiException};

class MailchimpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '44M');
        // try{
        $mailchimp = new ApiClient();
        $user = User::where('email' , 'mnoumanb@gmail.com')->first();
        try{
            $apiKey = 'a4de5625e0181799d0f4c124f43a7ccc';
            $serverPrefix = 'us21';
            $mailchimp->setConfig([
                    'apiKey' => $apiKey.'-'.$serverPrefix,
                    'server' => $serverPrefix,
                ]);

            $mailchimp->ping->get();

            $lists = $mailchimp->lists->getAllLists()->lists;
            
            $listId = $lists[0]->id;
            
            MailchimpIntegration::create([
                'user_id' => $user->id,
                'list_id' => $listId,
                'api_key' => $apiKey.'-'.$serverPrefix
            ]);
        
            

        }catch(\Exception $e){
            dd($e->getMessage());
        }  
        

    }
}
