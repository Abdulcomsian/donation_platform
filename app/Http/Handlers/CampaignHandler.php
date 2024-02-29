<?php

namespace App\Http\Handlers;
use App\Models\{Campaign , CampaignFrequency , Donation } ;

class CampaignHandler{

    public function createCampaign($request){
        
        $campaign = new Campaign();
        $campaign->title = $request->title;
        $campaign->excerpt = $request->excerpt;
        $campaign->description = $request->description;
        $campaign->recurring = $request->recurring;
        $campaign->user_id = auth()->user()->hasRole('owner') || auth()->user()->hasRole('admin') ? auth()->user()->id : \Helper::getOrganizationOwnerId();
        $campaign->created_by = auth()->user()->id;
        $campaign->campaign_goal = isset($request->campaign_goal) ? $request->campaign_goal : 0;
        $campaign->status = $request->status;
        $campaign->fee_recovery = $request->fee_recovery;
    
        $file = $request->file('file');
        $filename =  strtotime(now()).str_replace(" ", "-" ,$file->getClientOriginalName());
        $file->move(public_path('assets/uploads') , $filename);

        $campaign->image = $filename;

        if($request->campaign_goal){
            $campaign->amount = $request->amount;
            $campaign->expiry_date = $request->date;
            
        }

        $campaign->save();

        $frequencies = explode(",",$request->frequency);

        foreach($frequencies as $frequency){
           $campaignfrequency = new  CampaignFrequency;
           $campaignfrequency->campaign_id = $campaign->id;
           $campaignfrequency->type = $frequency;
           $campaignfrequency->save();
        }

     

        return ['status' => true , 'msg' => 'Campaign Created Successfully' , 'paramId' => $campaign->id];
    }


    public function editCampaign($request){
        $campaign = Campaign::where('id' , $request->campaign_id)->first();
        $campaign->title = $request->title;
        $campaign->excerpt = $request->excerpt;
        $campaign->description = $request->description;
        $campaign->recurring = $request->recurring;
        $campaign->campaign_goal = isset($request->campaign_goal) ? $request->campaign_goal : 0;
        $campaign->status = $request->status;
        $campaign->fee_recovery = $request->fee_recovery;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename =  strtotime(now()).str_replace(" ", "-" ,$file->getClientOriginalName());
            $file->move(public_path('assets/uploads') , $filename);
            $campaign->image = $filename;
        }


        if($request->campaign_goal){
            $campaign->expiry_date = $request->date;
            $campaign->amount = $request->amount;
            
        }else{
            $campaign->amount = null;
            $campaign->expiry_date = null;
        }

        $campaign->save();

        $frequencies = explode(",",$request->frequency);

        //deleting all the frequencies that are not in current frequency
        CampaignFrequency::where('campaign_id' , $request->campaign_id)->whereNotIn('type' , $frequencies)->delete();

        $campaignFrequencies = CampaignFrequency::where('campaign_id' , $request->campaign_id)->get()->pluck('type')->toArray();

        foreach($frequencies as $frequency){
            if(!in_array($frequency , $campaignFrequencies)){
                $campaignfrequency = new CampaignFrequency;
                $campaignfrequency->campaign_id = $request->campaign_id;
                $campaignfrequency->type = $frequency;
                $campaignfrequency->save();
            }
        }



        return ['status' => true , 'msg' => 'Campaign Updated Successfully' , 'paramId' => $campaign->id];
    }

    public function getCampaignWithId($id){
        return  Campaign::with('frequencies')->where('id' , $id)->first(); 
    }

    public function getCampaignList(){

        $campaigns= null;

        $query = Campaign::query();

        $query->with(['donations' => function($query1){
            $query1->where('status' , \AppConst::DONATION_COMPLETED)->with('plan');
        }]);

        if(auth()->user()->hasRole('admin')){
            $campaigns = $query->orderBy('id' , 'desc')->paginate(10);
        }else{
            if(auth()->user()->hasRole('owner')){
                $campaigns = $query->where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->paginate(10);
            }else{
                $campaigns = $query->where('created_by' , auth()->user()->id)->orderBy('id' , 'desc')->paginate(10);
            }
        }
        
        return $campaigns;
    }


    public function removeCampaign($id){
        Donation::where('campaign_id' , $id)->delete();
        Campaign::where('id' , $id)->delete();
    }

    public function getUserCampaigns(){
        if(auth()->user()->hasRole('admin'))
        {
            return Campaign::orderBy('id' , 'desc')->get();
        }
        else{
            if(auth()->user()->hasRole('owner')){
                return Campaign::where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->get();
            }  else {
                return Campaign::where('created_by' , auth()->user()->id)->orderBy('id' , 'desc')->get();
            }
        }
        // return  auth()->user()->hasRole('admin') ? Campaign::orderBy('id' , 'desc')->get() : Campaign::where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->get();


    }

    public function getDashboardCampaigns()
    {
        $query = Campaign::query();
        
        $query->when(!auth()->user()->hasRole('admin') , function($query1){

            $query1->when(auth()->user()->hasRole('fundraiser') || auth()->user()->hasRole('organization_admin') , function($query2){
                $query2->where('created_by' , auth()->user()->id);
            });

            $query1->when(auth()->user()->hasRole('owner'), function($query2){
                $query2->where('user_id' , auth()->user()->id);
            });

        });

        $query->with('donations' , 'donations.platformPercentage');

        $campaigns = $query->orderBy('id' , 'desc')->limit(2)->get();
        // $campaigns  = Campaign::with('donations.price' , 'donations.platformPercentage')->where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->limit(2)->get();
        return $campaigns;
    }

    public function getOrganizationCampaigns($request)
    {
        $id = \Crypt::decrypt($request->id);
    
        $campaigns  = Campaign::where('user_id' , $id)->orderBy('created_at' , 'desc')->paginate(10);

        return $campaigns;
    }

}