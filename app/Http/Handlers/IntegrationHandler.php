<?php


namespace App\Http\Handlers;
use App\Models\{  MailchimpIntegration};
use MailchimpMarketing\{ ApiClient , ApiException};

class IntegrationHandler{

    public function getAllMailchimpList($request)
    {
        $mailchimp = new ApiClient();
        $apiDetail = explode("-" , $request->apiKey);
        $apiKey = $apiDetail[0];
        $serverPrefix = $apiDetail[1];
        $mailchimp->setConfig([
                'apiKey' => $apiKey.'-'.$serverPrefix,
                'server' => $serverPrefix,
            ]);

        $mailchimp->ping->get();

        $lists = $mailchimp->lists->getAllLists()->lists;
       
        return ["status" => true , "msg" => $lists];
    }

    public function setMailchimpIntegration($request)
    {
        $apiKey = $request->apikey;

        $mailchimp = new ApiClient();
        $apiDetail = explode("-" , $request->apiKey);
        $apiKey = $apiDetail[0];
        $serverPrefix = $apiDetail[1];
        $mailchimp->setConfig([
                'apiKey' => $apiKey.'-'.$serverPrefix,
                'server' => $serverPrefix,
            ]);

        $mailchimp->ping->get();

        $lists = $mailchimp->lists->getAllLists()->lists;

        MailchimpIntegration::create([
            'user_id' => auth()->user()->id,
            'list_id' => $lists[0]->id,
            'api_key' => $apiKey,
            'name' => $lists[0]->name
        ]);

        return ["status" => true , "msg" => "Mailchimp Integrated Successfully"];

    }

}