<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Handlers\MembershipHandler;
use Illuminate\Support\Facades\Validator;
class MembershipController extends Controller
{
    protected $membershipHandler;

    function __construct(MembershipHandler $membershipHandler)
    {
        $this->membershipHandler = $membershipHandler;
    }

    public function membership()
    {
        [$monthlyPlans , $annuallyPlans] = $this->membershipHandler->membershipPlanList();
        return view('membership.index')->with(['monthlyPlans' => $monthlyPlans , 'annuallyPlans' => $annuallyPlans]);
    }


    public function createMembershipPlan(Request $request)
    {
        $validator = Validator::make( $request->all() , [
            "type" => "required|numeric",
            "name" => "required|string",
            "amount" => "required|numeric",
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
}
