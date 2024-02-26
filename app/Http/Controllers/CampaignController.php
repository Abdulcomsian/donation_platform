<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Handlers\{CampaignHandler , UserHandler};
use App\Models\{Campaign};

class CampaignController extends Controller
{
    protected $campaignHandler;
    protected $userHandler;

    function __construct(CampaignHandler $campaignHandler , UserHandler $userHandler)
    {
        $this->campaignHandler = $campaignHandler;
        $this->userHandler = $userHandler;
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
        $this->authorize('view'  , [Campaign::class , $request->id]);
        $campaign = $this->campaignHandler->getCampaignWithId($request->id);
        return view('campaigns.edit')->with(['campaign' => $campaign]);
    }

    public function campaignCreated(Request $request)
    {
        $campaignId = $request->campaignId;
        return view('campaigns.campaign-created')->with(['campaignId' => $campaignId]); 
    }

    public function campaignUpdated(Request $request)
    {
        $campaignId = $request->campaignId;
        return view('campaigns.campaign-updated')->with(['campaignId' => $campaignId]); 
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
                        'date' => 'date|nullable',
                        'status' => 'required|numeric',
                        'fee_recovery' => 'required|string'
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
            'date' => 'date|nullable',
            'status' => 'required|numeric',
            'fee_recovery' => 'required|string'
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

    public function getOrganizationCampaigns(Request $request)
    {

        $campaigns = $this->campaignHandler->getOrganizationCampaigns($request);

        $user = $this->userHandler->organizationProfile($request);

        return view('public.campaigns.campaign-list')->with(['campaigns' => $campaigns , 'user' => $user]);

    }


    
}
