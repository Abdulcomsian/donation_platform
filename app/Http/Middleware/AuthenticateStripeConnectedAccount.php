<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\OrganizationProfile;

class AuthenticateStripeConnectedAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $query = OrganizationProfile::query();

        $query->when(auth()->user()->hasRole('owner') , function($query1){
            $query1->where('user_id' , auth()->user()->id);
        });

        $query->when(auth()->user()->hasRole('fundraiser') || auth()->user()->hasRole('organization_admin') , function($query1){
            $query1->whereHas('organizationAdmin' , function($query2){
                $query2->where('user_id' , auth()->user()->id);
            });
        });

        $organizationProfile = $query->with('user')->first();

        if(isset($organizationProfile) && $organizationProfile->user->stripe_connected_id && $organizationProfile->user->stripe_is_verified)
        {
            return $next($request);
        }

        if($request->ajax())
        {
            return response()->json(['status' => false , 'msg' => 'Stripe Not Connected']);
        }else{

            \Toastr::error('Please Connect Your Stripe Account' , 'error');
            return redirect()->back();
        }
    }
}
