<?php

namespace App\Http\Handlers;
use Illuminate\Support\Facades\{Hash , DB};
use App\Models\{Country, OrganizationProfile, User};
use Spatie\Permission\Contracts\Role;

class SettingHandler{
    public function getUserDetail(){
        $user = User::with('organizationProfile')->where('id' , auth()->user()->id)->first();
        return $user;
    }

    public function countriesList(){
        return Country::all();
    }

    public function updateProfile($request)
    {
        $user = User::where('id' , auth()->user()->id)->first();
        $user->first_name = $request->firstname;
        $user->last_name = $request->lastname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->country_id = $request->country ?? null;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = time()."-".$file->getClientOriginalName();
            $file->move(public_path('assets/uploads/profile_image') , $fileName);
            $user->profile_image = $fileName;
        }

        $user->save();

        return ['status' => true , 'msg' => 'Profile Updated Successfully'];

    }

    public function updatePassword($request)
    {
        $oldPassword = $request->old_password;

        if(Hash::check($oldPassword , auth()->user()->password)){
            $user = User::where('id' , auth()->user()->id)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            return ['status' => true , 'msg' => 'Password Updated Successfully' ];

        }else{  
            return ['status' =>false , 'msg' => 'Something Went Wrong' , 'error' => 'Please Enter Correct Old Password' ];
        }

    }

    public function roles()
    {
        return DB::table('roles')->whereIn( 'name', ['non_profit_organization' , 'fundraiser'])->get();
    }

    public function updateOrganization($request)
    {
        $fileName = null;

        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = time()."-".$file->getClientOriginalName();
            $file->move(public_path('assets/uploads/profile_image') , $fileName);
        }


        OrganizationProfile::updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['user_id' => auth()->user()->id , 'name' => $request->organization_name , 'description' => $request->description , 'type' => $request->type , 'link' => $request->website , 'logo_link' => $fileName]
        );

        return ['status' => true , 'msg' => 'Organization Profile Updated Successfully'];
    }
}