<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Handlers\{MembershipHandler , UserHandler};
use Illuminate\Support\Facades\{Validator};
class MembershipController extends Controller
{
    protected $membershipHandler;
    protected $userHandler;

    function __construct(MembershipHandler $membershipHandler , UserHandler $userHandler)
    {
        $this->membershipHandler = $membershipHandler;
        $this->userHandler = $userHandler;
    }

    public function membership()
    {
        [$monthlyPlans , $annuallyPlans] = $this->membershipHandler->membershipPlanList();
        return view('membership.index')->with(['monthlyPlans' => $monthlyPlans , 'annuallyPlans' => $annuallyPlans]);
    }


    public function createMembershipPlan(Request $request)
    {
        $validator = Validator::make( $request->all() , [
            "plans" => "required|array|min:1",
            "plans.*.name" => "required|string",
            "plans.*.amount" => "required|numeric",
            "plans.*.type" => "required|numeric",
        ]); 
    

        if($validator->fails())
        {
             return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode(" ," ,$validator->messages()->all())]);
        }

        try{

            $response = $this->membershipHandler->createMembershipPlan($request);

            return response()->json($response);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
    }

    public function removeMembership(Request $request)
    {
        $validator = Validator::make( $request->all() , [
            "planId" => "required|numeric",
        ]);
        
        if($validator->fails())
        {
             return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode(" ," ,$validator->messages()->all())]);
        }

        try{

            $response = $this->membershipHandler->deleteMembershipPlan($request);

            return response()->json($response);
        }
        catch(\Exception $e) 
        {
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }


    }

    public function getMembershipList(Request $request)
    {
        $userPlans = $this->membershipHandler->getMembershipPlanList($request);
        // $setupIntent = $this->membershipHandler->createSetupIntent($userPlans->stripe_connected_id);
        return view('membership.subscribe-plans')->with(['userPlans' => $userPlans  , 'connectedId' => $userPlans->stripe_connected_id ]);
    }

    public function subscribeMembership(Request $request)
    {
        $validator = Validator::make( $request->all() , [
            "plan" => "required|numeric",
            "payment_method" => "required|string",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "email" => "required|email",
        ]);
        
        if($validator->fails())
        {
             return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode(" ," ,$validator->messages()->all())]);
        }

        try{

            $response = $this->membershipHandler->subscribeUserInPlan($request);
            return response()->json($response);
        }catch(\Exception $e) {
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
    }


    public function getOrganizationMembershipPlans(Request $request)
    {
        $organizationName = $request->organizationName;

        $userPlans = $this->membershipHandler->getOrganizationPlans($request);

        $user = $this->userHandler->organizationProfile($request);

        $setupIntent = $this->membershipHandler->createSetupIntent($userPlans->stripe_connected_id);

        return view('public.membership.membership-list')->with([ 
                                                                 'userPlans' => $userPlans , 
                                                                 'user' => $user , 
                                                                 'clientSecret' => $setupIntent->client_secret , 
                                                                 'connectedId' => $userPlans->stripe_connected_id,
                                                                 'organizationName' => $organizationName
                                                                ]);
    
    }
}
