<?php

namespace App\Http\Controllers;

use App\Http\Handlers\UserHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userHandler;

    function __construct(UserHandler $userHandler)
    {
        $this->userHandler = $userHandler;    
    }

    public function logoutUser(){
        auth()->logout();
        return redirect()->route('login');
    }

    public function getUserList()
    {
        return $this->userHandler->userList();
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all() , [
            "first_name" => "required|string",
            "last_name" => "required|string",
            "role" => "required|numeric",
            "email" => "required|unique:users,email"
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( " ," ,$validator->messages()->all()) ]);
        }

        try{
            $response = $this->userHandler->addNewUser($request);
            return response()->json($response);
        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }

    }

    public function updateRole(Request $request)
    {
        $validator = Validator::make($request->all() , [
            "role" => "required|string",
            "userId" => "required|numeric",
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( " ," ,$validator->messages()->all()) ]);
        }

        try{
            $response = $this->userHandler->changeUserRole($request);
            return response()->json($response);

        }catch(\Exception $e){

            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        
        }
    }

    public function deleteUser(Request $request)
    {
        $validator = Validator::make($request->all() , [
            "userId" => "required|numeric",
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( " ," ,$validator->messages()->all()) ]);
        }

        try{
            $response = $this->userHandler->deleteUser($request);
            return response()->json($response);

        }catch(\Exception $e){

            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        
        }
    }
}
