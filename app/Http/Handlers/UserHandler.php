<?php

namespace App\Http\Handlers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserHandler{

    public function latestMemberCount()
    {
        $query = User::query();

        $query->when(!auth()->user()->hasRole('admin') , function($query){
            $query->whereHas('donations' , function($query1){
                $query1->whereHas('campaign' , function($query2){
                    $query2->where('user_id' , auth()->user()->id);
                });
            });
        });
        $newMemebersCount = $query->where(DB::raw('created_at') , '>=' , now()->firstOfMonth())->count();


        return $newMemebersCount;
    }

    public function recurringDonarCount()
    {
        $query  = User::query();
                
        $query->whereHas('donations' , function($query){
            $query->when(!auth()->user()->hasRole('admin') , function($query1){
                $query1->whereHas('campaign' , function($query1){
                    $query1->where('user_id' , auth()->user()->id);
                });
            });
            $query->select('donar_id')
            ->groupBy('donar_id')
            ->havingRaw('COUNT(donar_id) > 1');
        });
        
        $recurringDonarCount = $query->count();
    
        return $recurringDonarCount;
    }

    public function userList()
    {
        // dd(User::with('roles')
        // ->whereDoesntHave('roles', function ($query) {
        //     $query->whereIn('name', ['admin', 'donor']);
        // })
        // ->orderBy('id', 'desc')
        // ->get());
        $users = User::with('roles')->whereDoesntHave('roles' , function($query){
                                            $query->whereIn('name' , ['admin' , 'donor']);
                                        })
                                        ->orderBy('id' , 'desc')
                                        ->get();
                                        

        $roles = DB::table('roles')->whereIn( 'name' , ['fundraiser' , 'non_profit_organization'])->get();


        return DataTables::of($users)
              ->addColumn('name' , function($user){
                return $user->first_name.' '.$user->last_name;
              })
              ->addColumn('email' , function($user){
                return $user->email;
              })
              ->addColumn('role' , function($user) use ($roles){
                $html = '<select name="role" class="role  form-control add-arrow" data-user-id="'.$user->id.'">';
                $currentRole = $user->roles->first(function($role){
                    if(in_array($role->name , ['fundraiser' , 'non_profit_organization'])){
                        return $role;
                    }
                });
                foreach($roles as $role){
                    $roleName = ucfirst(str_replace("_" , " ", $role->name));
                    $attribute = $currentRole->name == $role->name  ? 'selected' : '';
                    $html .= '<option value="'.$role->name.'" '.$attribute.' >'.$roleName.'</option>';
                }
                $html .= '</select>';
                return $html;
              })
              ->addColumn('status' , function($user){

                    switch($user->activation_status)
                    {
                        case \AppConst::PENDING:
                            return '<p class="text-warning text-center my-0">Pending</p>';
                        break;
                        case \AppConst::ACTIVATED:
                            return '<p class="text-success text-center my-0">Active</p>';
                        break;
                        case \AppConst::REJECTED:
                            return '<p class="text-danger text-center my-0">Rejected</p>';
                        break;
                    }
              })
              ->addColumn('action' , function($user){
                $imgUrl = asset('assets/images/trash-outline.png');
               return  '<div class="d-flex justify-content-center">
                            <button type="button" class="delete-container delete-user-btn r-btn" data-user-id="'.$user->id.'">
                                <img src="'.$imgUrl.'" alt="">
                            </button>
                        </div>';
              })
              ->rawColumns(['name' , 'email' , 'role' ,'status' , 'action'])
              ->make(true);
    }


    function addNewUser($request){
        $firstName = $request->first_name;
        $lastName = $request->last_name;
        $email = $request->email;
        $role = $request->role;


        $user  = new User;
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;

        if($user->save())
        {
            $role == \AppConst::NON_PROFIT_ORGANIZATION ? $user->assignRole('non_profit_organization') : $user->assignRole('fundraiser');
        }

        return ['status' => true , 'msg' => 'User Created Successfully'];

    }

    function changeUserRole($request){
        $role = $request->role;
        $userId = $request->userId;
        $user = User::where('id' , $userId)->first();
        
        if($role == 'non_profit_organization'){
            $user->removeRole('fundraiser');
            $user->assignRole($role);
        }else{
            $user->removeRole('non_profit_organization');
            $user->assignRole($role);
        }

        return ['status' => true , 'msg' => 'User Role Updated Successfully'];

    }

    function deleteUser($request)
    {
        $userId = $request->userId;
        User::where('id' , $userId)->delete();
        return ['status' => true , 'msg' => 'User Deleted Successfully'];
    }


}