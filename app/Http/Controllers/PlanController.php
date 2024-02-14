<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Handlers\PlanHandler;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    protected $planHandler;

    function __construct(PlanHandler $planHandler)
    {
        $this->planHandler = $planHandler;
    }

    public function createPlan(Request $request)
    {
        $validator  = Validator::make($request->all() , [
            'name' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => implode("," , $validator->messages()->all())]);
        }

        try{
             $response = $this->planHandler->createPlan($request);
             return response()->json($response);
        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => $e->getMessage()]);
        }
    }

    public function planList()
    {
        return $this->planHandler->getPlanList();
    }

    public function deletePlan(Request $request)
    {
        $validator  = Validator::make($request->all() , [
            'planId' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => implode("," , $validator->messages()->all())]);
        }

        try{
             $response = $this->planHandler->removePlan($request);
             return response()->json($response);
        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => $e->getMessage()]);
        }
    }
}
