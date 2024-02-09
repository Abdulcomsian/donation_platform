<?php

namespace App\Http\Handlers;

use App\Models\{ User , OrganizationAdmin};
use Illuminate\Support\Facades\{ DB , Hash , Crypt};
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

    public function adminList()
    {
        
        
        $user =  User::with('organizationProfile' , 'organizationAdmin')->where('id' , auth()->user()->id)->first();
        $organizationId = []; 
        $user->organizationProfile ? $organizationId[] = $user->organizationProfile->id : $organizationId = $user->organizationAdmin->pluck('id')->toArray();


        $users = User::with('roles')
                    ->whereHas('organizationAdmin' , function($query) use ($organizationId){
                                    $query->whereIn('organization_id' , $organizationId);
                    })
                    ->where('id' , '!=' , auth()->user()->id)->get();
                                        

        $roles = DB::table('roles')->whereIn( 'name' , ['organization_admin'])->get();


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
                    if(in_array($role->name , ['organization_admin'])){
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


    public function addNewAdmin($request){
        $firstName = $request->first_name;
        $lastName = $request->last_name;
        $email = $request->email;
        $role = $request->role;
        $user  = new User;
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->activation_status = \AppConst::PENDING;

        $organizationOwner = User::with('organizationProfile')->where('id' , auth()->user()->id)->first();

        if($user->save())
        {
            $role == \AppConst::ORGANIZATION_ADMIN ? $user->assignRole('organization_admin') : $user->assignRole('fundraiser');
            OrganizationAdmin::create([ 'organization_id' => $organizationOwner->organizationProfile->id , 'user_id' => $user->id]);
            $user->assignRole('organization_admin');
            \Mail::to($user->email)->send(new \App\Mail\OrganizationInvitationMail($user->id));
        }

        return ['status' => true , 'msg' => 'Admin added successfully and invitation has been sent to user'];

    }

    public function changeUserRole($request){
        $role = $request->role;
        $userId = $request->userId;
        $user = User::where('id' , $userId)->first();
        
        if($role == 'owner'){
            $user->removeRole('fundraiser');
            $user->assignRole($role);
        }else{
            $user->removeRole('owner');
            $user->assignRole($role);
        }

        return ['status' => true , 'msg' => 'User Role Updated Successfully'];

    }

    public function deleteUser($request)
    {
        $userId = $request->userId;
        User::where('id' , $userId)->delete();
        return ['status' => true , 'msg' => 'User Deleted Successfully'];
    }

    public function getUserDetail()
    {
        $userId = auth()->user()->id;
        $user = User::with('organizationProfile')->where('id' , $userId)->first();
        return $user;
    }

    public function setInvitationUserPassword($request)
    {
        $id = Crypt::decrypt($request->user_id);
        $password = Hash::make($request->password);
        User::where('id' , $id)->update(['password' => $password]);
        \Toastr::success('Your password has been reset please verify' , 'Success' );
        return redirect()->route('login');
    }




}