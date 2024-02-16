<?php

namespace App\Http\Controllers;
use App\Http\Handlers\{DonationHandler , UserHandler , CampaignHandler , EventHandler, SettingHandler};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class DashboardController extends Controller
{

    protected $donationHandler;
    protected $userHandler;
    protected $campaignHandler;
    protected $settingHandler;
    protected $eventHandler;


    function __construct(DonationHandler $donationHandler , UserHandler $userHandler , CampaignHandler $campaignHandler , SettingHandler $settingHandler , EventHandler $eventHandler)
    {
        $this->donationHandler = $donationHandler;
        $this->userHandler = $userHandler;
        $this->campaignHandler = $campaignHandler;
        $this->settingHandler = $settingHandler;
        $this->eventHandler = $eventHandler;
    }


    public function dashboard()
    {
        [$recievedAmount , $totalAmount] = $this->donationHandler->calculateDonationAmount(\AppConst::DONATION_COMPLETED , false);
        $donationCount = $this->donationHandler->totalDonationCount();
        $latestMemebersCount = $this->userHandler->latestMemberCount();
        $recurringDonarCount = $this->userHandler->recurringDonarCount();
        $purchaseTicketCount = $this->eventHandler->totalTicketCount();
        $userDetail = $this->userHandler->getUserDetail();
        $dashboardCampaigns  = $this->campaignHandler->getDashboardCampaigns(); 
        $latestDonations = $this->donationHandler->getlatestDonars();

        return view('dashboard.index')->with([
                                              'dashboardCampaigns' => $dashboardCampaigns , 
                                              'latestDonations' => $latestDonations , 
                                              'recievedAmount' => $recievedAmount , 
                                              'totalAmount' => $totalAmount,
                                              'donationCount' => $donationCount,
                                              'membersCount' => $latestMemebersCount,
                                              'recurringDonor' => $recurringDonarCount,
                                              'userDetail' => $userDetail,
                                              'purchaseTicketCount' => $purchaseTicketCount
                                            ]);
    }


    public function uploadLogo(Request $request)
    {
        $validator  = Validator::make($request->all() , [
            'file' => 'file|mimes:jpeg,png,jpg,PNG,JPEG,JPG',
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( " ,", $validator->messages()->all())]);
        }

        try{

            $response = $this->settingHandler->updateOrganizationLogo($request);
            return response()->json($response);
            
        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
    }
}
