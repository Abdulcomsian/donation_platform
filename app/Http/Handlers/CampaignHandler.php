<?php

namespace App\Http\Handlers;
use App\Models\Campaign;
use App\Models\CampaignFrequency;
use GuzzleHttp\Psr7\Request;

class CampaignHandler{

    public function createCampaign($request){
        
        $campaign = new Campaign();
        $campaign->title = $request->title;
        $campaign->excerpt = $request->excerpt;
        $campaign->description = $request->description;
        $campaign->recurring = $request->recurring;
        $campaign->user_id = auth()->user()->id;
        $campaign->campaign_goal = isset($campaign->campaign_goal) ? $campaign->campaign_goal : 0;

        $file = $request->file('file');
        $filename =  strtotime(now()).str_replace(" ", "-" ,$file->getClientOriginalName());
        $file->move(public_path('assets/uploads') , $filename);

        $campaign->image = $filename;

        if($request->campaign_goal){
            $campaign->amount = $request->amount;
            $campaign->fee_recovery = $request->fee_recovery;
        }

        $campaign->date = $request->date;
        $campaign->save();

        $frequencies = explode(",",$request->frequency);

        foreach($frequencies as $frequency){
           $campaignfrequency = new  CampaignFrequency;
           $campaignfrequency->campaign_id = $campaign->id;
           $campaignfrequency->type = $frequency;
           $campaignfrequency->save();
        }

        return ['status' => true , 'msg' => 'Campaign Created Successfully'];
    }

    public function getCampaignWithId($id){
        return  Campaign::with('frequency')->where('id' , $id)->first(); 
    }
    
    public function getCampaignList(){
        $campaigns = null;
        if(auth()->user()->type != \AppConst::ADMIN){
            $campaigns = Campaign::where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->paginate(10);
        }else{
            $campaigns = Campaign::orderBy('id' , 'desc')->paginate(10);
        }
        return $campaigns;
    }

}