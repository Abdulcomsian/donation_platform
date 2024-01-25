<?php

namespace App\Http\Controllers;
use App\Http\Handlers\{DonationHandler , UserHandler , CampaignHandler};
use Illuminate\Http\Request;
class DashboardController extends Controller
{

    protected $donationHandler;
    protected $userHandler;
    protected $campaignHandler;

    function __construct(DonationHandler $donationHandler , UserHandler $userHandler , CampaignHandler $campaignHandler)
    {
        $this->donationHandler = $donationHandler;
        $this->userHandler = $userHandler;
        $this->campaignHandler = $campaignHandler;
    }


    public function dashboard()
    {
        [$recievedAmount , $totalAmount] = $this->donationHandler->calculateDonationAmount(\AppConst::DONATION_COMPLETED , false);
        $donationCount = $this->donationHandler->totalDonationCount();
        $latestMemebersCount = $this->userHandler->latestMemberCount();
        $recurringDonarCount = $this->userHandler->recurringDonarCount();
        $dashboardCampaigns  = $this->campaignHandler->getDashboardCampaigns(); 
        $latestDonations = $this->donationHandler->getlatestDonars();


        return view('dashboard.index')->with([
                                              'dashboardCampaigns' => $dashboardCampaigns , 
                                              'latestDonations' => $latestDonations , 
                                              'recievedAmount' => $recievedAmount , 
                                              'totalAmount' => $totalAmount,
                                              'donationCount' => $donationCount,
                                              'membersCount' => $latestMemebersCount,
                                              'recurringDonor' => $recurringDonarCount
                                            ]);
    }


    public function uploadLogo(Request $request){

    }
}
