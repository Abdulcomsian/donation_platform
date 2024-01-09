<?php

namespace App\Http\Handlers;
use App\Models\Campaign;

class CampaignHandler{

    public function createCampaign($request){
        
        $campaign = new Campaign();
        $campaign->title = $request->title;
        $campaign->excerpt = $request->excerpt;
        $campaign->description = $request->description;
        $campaign->frequency = $request->frequency;
        $campaign->recurring = $request->recurring;

        $file = $request->file('file');
        $filename =  strtotime(now()).str_replace(" ", "-" ,$file->getClientOriginalName());
        $file->move(public_path('uploads') , $filename);

        $campaign->image = $filename;

        if($request->campaign_goal){
            $campaign->amount = $request->amount;
            $campaign->fee_recovery = $request->fee_recovery;
        }

        $campaign->date = $request->date;
        $campaign->save();

        return ['status' => true , 'msg' => 'Campaign Created Successfully'];
    }

    public function getCampaignList(){
        $campaigns = Campaign::where('user_id' , auth()->user()->id)->paginate(10);
        return $campaigns;
    }

}