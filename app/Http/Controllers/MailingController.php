<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Handlers\{MailingHandler};

class MailingController extends Controller
{
    protected $mailingHandler;
    
    function __construct(MailingHandler $mailHandler)
    {
        $this->mailingHandler = $mailHandler;
    }


    public function updateUserMail(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'type' => 'required|numeric',
            'description' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }
                
        try{

            $response = $this->mailingHandler->updateUserMail($request);
            return response()->json($response);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
    }
}
