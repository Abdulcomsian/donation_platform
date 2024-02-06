<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Handlers\IntegrationHandler;
use Illuminate\Support\Facades\Validator;

class IntegrationController extends Controller
{
    protected $integrationHandler;

    function __construct(IntegrationHandler $integrationHandler)
    {
        $this->integrationHandler = $integrationHandler;
    }

    public function getMailchimpLists(Request $request){
        try{
            $this->integrationHandler->getAllMailchimpList($request);
        }catch(\Exception $e){
            return response()->json(["status" => false , "msg" => "Something Went Wrong" , "error" => $e->getMessage()]);
        }
    }

    public function integrateMailchimp(Request $request)
    {
        $validator = Validator::make($request->all() , [
                                    'id' => 'required|numeric',
                                    'name' => 'required|string',
                                    'apiKey' => 'required|string'
                                ]);
        
        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }
                    
        try{
            $response = $this->integrationHandler->setMailchimpIntegration($request);
            return response()->json($response);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
    }
}
