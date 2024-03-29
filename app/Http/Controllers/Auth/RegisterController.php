<?php

namespace App\Http\Controllers\Auth;

use App\Http\AppConst;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\{User , OrganizationProfile , Address};
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Country;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }




    public function showRegistrationForm()
    {
        $countries = Country::get();
        return view('auth.register-main')->with(['countries' => $countries]);
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data , [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'country' => ['nullable', 'numeric'],
            'type' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'organization_name' => [Rule::requiredIf($data['type'] == AppConst::NON_PROFIT_ORGANIZATION) , 'string' , 'max:255'],
            'organization_type' => [Rule::requiredIf($data['type'] == AppConst::NON_PROFIT_ORGANIZATION) , 'string' , 'max:255'],
            'organization_description' => [Rule::requiredIf($data['type'] == AppConst::NON_PROFIT_ORGANIZATION) , 'string' , 'max:255'],
            'organization_website' => [Rule::requiredIf($data['type'] == AppConst::NON_PROFIT_ORGANIZATION) , 'string' , 'max:255'],
            'organization_phone' => [Rule::requiredIf($data['type'] == AppConst::NON_PROFIT_ORGANIZATION) , 'string' , 'max:255'],
            'platform' => [Rule::requiredIf($data['type'] == AppConst::NON_PROFIT_ORGANIZATION) , 'string' , 'max:255'],
        ]);
        // return Validator::make($data, [
        //     'first_name' => ['required', 'string', 'max:255'],
        //     'last_name' => ['required', 'string', 'max:255'],
        //     'country' => ['required', 'numeric'],
        //     'type' => ['required', 'numeric'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        
        if(!is_null($data['country'])){
            Address::create([
                'country_id' => $data['country'],
                'addressable_id' => $user->id,
                'addressable_type' => 'App\Models\Address'
            ]);
        }
        
        $data['type'] == AppConst::NON_PROFIT_ORGANIZATION ? $user->assignRole('non_profit_organization') : $user->assignRole('fundraiser');
        
        if($data['type'] == AppConst::NON_PROFIT_ORGANIZATION){

            OrganizationProfile::create([
                'name' => $data['organization_name'],
                'type' => $data['organization_type'],
                'description' => $data['organization_description'],
                'link' => $data['organization_website'],
                'phone' => $data['organization_phone'],
                'platform' => $data['platform'],
                'user_id' => $user->id
            ]);
        }

        return $user;
    }
}
