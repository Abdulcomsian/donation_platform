<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Handlers\{SettingHandler};
class SettingController extends Controller
{   
    protected $settingHandler;

    function __construct(SettingHandler $settingHandler)
    {
        $this->settingHandler = $settingHandler;
    }

    public function settings()
    {
        $userDetail = $this->settingHandler->getUserDetail();
        $countries = $this->settingHandler->countriesList();
        $roles = $this->settingHandler->roles();
        return view('settings.index')->with(['user' => $userDetail , 'countries' => $countries , 'roles' => $roles]);
    }

    public function changeProfileSettings(Request $request)
    {
        
        $validator = Validator::make( $request->all() , [
                                    "firstname" => "required|string",
                                    "lastname" => "required|string",
                                    "email" => "required|email",
                                    "country" => "nullable|numeric",
                                    "phone" => "required|string",
                                    "file" => "nullable|mimes:jpg,jpeg,png,bmp,tiff |max:4096"
                                ]); 

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode(" ," ,$validator->messages()->all())]);
        }

        try{
            
            $response = $this->settingHandler->updateProfile($request);
    
            return response()->json($response);
        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
        
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make( $request->all() , [
            "old_password" => "required|string",
            "password" => "required|string|same:password_confirmation|min:5",
            "password_confirmation" => "required|min:5"
        ]); 

        
        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode(" ," ,$validator->messages()->all())]);
        }
        
        try{
            $response = $this->settingHandler->updatePassword($request);
    
            return response()->json($response);
        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }

    }

    public function updateOrganization(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            "organization_name" => "required|string",
            "type" => "required|string",
            "description" => "required|string",
            "website" => "required|string",
            "file" => "nullable|mimes:jpg,jpeg,png,bmp,tiff |max:4096"
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode(" ," ,$validator->messages()->all())]);
        }

        try{
            $response = $this->settingHandler->updateOrganization($request);
    
            return response()->json($response);

        }catch(\Exception $e){
            
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        
        }

        
    }

    
}
