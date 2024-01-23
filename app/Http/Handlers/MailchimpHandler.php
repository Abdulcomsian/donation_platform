<?php

namespace App\Http\Handlers;

use MailchimpMarketing\{ApiClient , ApiException};
use GuzzleHttp\Exception\ClientException;
// use Symfony\Component\HttpKernel\Exception\Http$exception instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterfaceExceptionInterface;

class MailchimpHandler{

    protected $client;

    function __construct($apiKey)
    {
        $this->client = new ApiClient;
        $serverPrefix = explode("-" , $apiKey)[1];

        $configDetails = [
            'apiKey' => $apiKey,
            'server' => $serverPrefix
        ];
        $this->client->setConfig($configDetails);
    }

    public function findSubscriber($listId , $email){
        try{
            $memberExist = $this->client->lists->getListMember($listId , md5(strtolower($email)));
            return isset($memberExist) ? true : false;
        }catch(\Exception $e){
            return false;
        }
    }

    
    public function addSubscriber($listId , $email){
        try {
            $response = $this->client->lists->addListMember($listId, [
                "email_address" => $email,
                "status" => "subscribed",
            ]);
        }catch (ClientException $e) {
             $response = json_decode($e->getResponse()->getBody()->getContents());
          }
    }

    
}