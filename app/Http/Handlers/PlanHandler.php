<?php 

namespace App\Http\Handlers;
use App\Models\{ Plan , PlanInterval , User};
use Stripe\{Plan as StripePlan , Stripe , Product , Price};
use Yajra\DataTables\DataTables;


class PlanHandler{

    public function createPlan($request){
        $amount = $request->amount;
        $name = $request->name;

        $planList = Plan::where(['user_id' => auth()->user()->id])->get();
        
        $findPlan =  $planList->first(function($plan) use ($amount){
            return $plan->amount == $amount;
        });

        if($findPlan){
            return ['status' => false , 'msg' => 'Already Plan Exist With Same Amount'];
        }

        if($planList->count() == 6){
            return ['status' => false , 'msg' => 'Maximum Plan Limit Reached'];
        }
    
        
        $plan = Plan::create([
            'name' => $name,
            'amount' => $amount,
            'user_id' => auth()->user()->id
        ]);


        $intervals = ['month' , 'quarter' , 'year' ];

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $planIntervals = [];

        foreach($intervals as $interval)
        {
            $planName = $interval == 'quarter' ?  'Plan '.$amount.' quarter' :  'Plan '.$amount.' '.ucfirst($interval);

            $user =  User::where('id' , auth()->user()->id)->first();


            $product = Product::create( 
                    ['name' => $planName],
                    ['stripe_account' => auth()->user()->stripe_connected_id]
                );

            $price = Price::create([
                'product' => $product->id,
                'unit_amount' => $amount * 100,
                'currency' => 'usd',
                'recurring' => [
                    'interval' => 'month',
                    'interval_count' => $interval == 'quarter' ? 3 : null
                ]
                ], ['stripe_account' => auth()->user()->stripe_connected_id]);


//             $stripePlan =  StripePlan::create([
//                                 'amount' => $amount * 100, 
//                                 'interval' => $interval == 'quarter' ? 'month' : $interval,
//                                 'interval_count' => $interval == 'quarter' ? 3 : null,
//                                 'product' => [
//                                     'name' => $planName, 
//                                 ],
//                                 'currency' => 'usd',
//                             ], ['stripe_account' => auth()->user()->stripe_connected_id]);
// dd($stripePlan);

            $planIntervals[] = ['plan_id' => $plan->id , 'stripe_plan_id' => $price->id , 'interval' => $interval ];
        }

        PlanInterval::insert($planIntervals);


        return ['status' => true , 'msg' => 'Plan Created Successfully'];
        

    }

    public function getPlanList()
    {
        $plans = Plan::where('user_id' , auth()->user()->id)->orderBy('amount' , 'asc')->get();
        return DataTables::of($plans)
                ->addColumn('name' , function($plan){
                    return $plan->name;
                })
                ->addColumn('amount' , function($plan){
                    return '$'.$plan->amount;
                })
            
                ->addColumn('action' , function($plan){
                $imgUrl = asset('assets/images/trash-outline.png');
                return  '<div class="d-flex justify-content-center">
                            <button type="button" class="delete-container delete-plan-btn r-btn" data-plan-id="'.$plan->id.'">
                                <img src="'.$imgUrl.'" alt="">
                            </button>
                        </div>';
                })
                ->rawColumns(['name' , 'amount' , 'action'])
                ->make(true);
    }

    public function removePlan($request){
        $planId= $request->planId;
        Plan::where('id' , $planId)->delete();
        return ['status' => true , 'msg' => 'Plan Deleted Successfully'];
    }

}