<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Handlers\CampaignHandler;
class CampaignController extends Controller
{
    protected $campaignHandler;

    function __construct(CampaignHandler $campaignHandler)
    {
        $this->campaignHandler = $campaignHandler;
    }

    public function campaign(){
        $campaigns = $this->campaignHandler->getCampaignList();
        return view('campaigns.index')->with(['campaigns' => $campaigns]);
    }

    public function getCampaignForm()
    {
        return view('campaigns.create');
    }

    public function createCampaign(Request $request){

        $validator = Validator::make($request->all() , [
                        'title' => 'required|string',
                        'excerpt' => 'required|string',
                        'description' => 'required|string',
                        'file' => 'file|nullable|mimes:jpeg,png,jpg,PNG,JPEG,JPG',
                        'frequency' => 'required|string',
                        'recurring' => 'required|string',
                        'campaign_goal' => 'required|boolean',
                        'amount' => [Rule::requiredIf($request->campaing_goal == 1) , 'numeric'],
                        'fee_recovery' => Rule::requiredIf($request->campaing_goal == 1),
                        'date' => 'required|date'
                    ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $validator->getMessageBag()]);
        }

        try{

            $response = $this->campaignHandler->createCampaign($request);
            return response()->json($response);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }


    }
    
}
