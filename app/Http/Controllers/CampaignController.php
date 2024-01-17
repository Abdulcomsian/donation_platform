<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Handlers\CampaignHandler;
use App\Models\Campaign;

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

    public function editCampaignForm(Request $request)
    {
        $campaign = $this->campaignHandler->getCampaignWithId($request->id);
        return view('campaigns.edit')->with(['campaign' => $campaign]);
    }

    public function campaignCreated()
    {
        return view('campaigns.campaign-created'); 
    }

    public function campaignUpdated()
    {
        return view('campaigns.campaign-updated'); 
    }

    public function createCampaign(Request $request){

        $validator = Validator::make($request->all() , [
                        'title' => 'required|string',
                        'excerpt' => 'required|string',
                        'description' => 'required|string',
                        'file' => 'file|required|mimes:jpeg,png,jpg,PNG,JPEG,JPG',
                        'frequency' => 'required|string',
                        'recurring' => 'required|string',
                        'campaign_goal' => 'nullable|boolean',
                        'amount' => [Rule::requiredIf($request->campaign_goal == 1)],
                        'fee_recovery' => Rule::requiredIf($request->campaign_goal == 1),
                        'date' => 'required|date',
                        'status' => 'required|numeric'
                    ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }
                    
        try{
            $response = $this->campaignHandler->createCampaign($request);
            return response()->json($response);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }


    }

    public function editCampaign(Request $request){
        $validator = Validator::make($request->all() , [
            'title' => 'required|string',
            'excerpt' => 'required|string',
            'description' => 'required|string',
            'frequency' => 'required|string',
            'recurring' => 'required|string',
            'campaign_goal' => 'nullable|boolean',
            'amount' => [Rule::requiredIf($request->campaign_goal == 1)],
            'fee_recovery' => Rule::requiredIf($request->campaign_goal == 1),
            'date' => 'required|date',
            'status' => 'required|numeric'
        ]);

        
        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }
                    
        try{
            $response = $this->campaignHandler->editCampaign($request);
            return response()->json($response);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
             
    }


    public function deleteCampaign(Request $request){
        
        try{
            $id = $request->id;
            $this->campaignHandler->removeCampaign($id);
            \Toastr::success('Campaign Removed Successfully' , 'Success!');
            return redirect()->back();

        }catch(\Exception $e){
            \Toastr::error('Something Went Wrong' , 'Error!');
            \Toastr::error($e->getMessage() , 'Error!' );
            return redirect()->back();
        }

    }


    
}
