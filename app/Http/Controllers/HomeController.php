<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\City;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // auth()->logout();
        return view('home');
    }

    public function getCitiesList(Request $request)
    {
        $countryId = $request->country;
        $cities = City::where('country_id' , $countryId)->get();
        $cities = view('components.ajax.city-list' , ['cities' => $cities])->render();
        return response()->json(['status' => true , 'cities' => $cities]);
    }
}
