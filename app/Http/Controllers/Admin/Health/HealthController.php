<?php

namespace App\Http\Controllers\Admin\Health;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\HealthActivities;
use App\Http\Controllers\Controller;
use App\Http\Utility\commonHelper;

class HealthController extends Controller
{
    
    public function index(){

       $healthList = HealthActivities::leftjoin('users','users.last_uuid','health_activities.health_activities_uuid')->get(); 
       return view('admin.health.view',compact('healthList'));
    } 

    public function useractivity(Request $request){

       $healthList = HealthActivities::leftjoin('users','users.last_uuid','health_activities.health_activities_uuid')
       ->where('health_activities.health_activities_uuid',$request->id)
       ->orderBy('health_activities.health_activities_id','DESC')
       ->get(); 
       return view('admin.health.view',compact('healthList'));
    }


    public function edit(Request $request){

        $user = HealthActivities::FindorFail($request->id); 
        return view('admin.health.edit',compact('user'));
    }

    public function update(Request $request)
    {
           
        $path = 'users';
        $commonHelper = new commonHelper;
        
        if(!empty($request->userImage)){

            $saveImage= $commonHelper->imageUpload($request->userImage,$path); 
        }else{

            $saveImage= NULL;
        }

        //save Users
        $users = User::FindorFail($request->id);

        $users->name = $request->userName;
        isset($saveImage) ? $users->image = $saveImage : '';
        $users->email = $request->userEmail;
        $users->phone = $request->userPhone;
        $users->save();


        return redirect('/health')->with('success','User Edited successfully.');

    }


    public function delete(Request $request)
    {
        $users = HealthActivities::FindorFail($request->id);
        $users->deleted_at = date('Y-m-d H:i:s');
        $users->save();
        return redirect('/health')->with('error','User Deleted successfully');
    }


    public function detail(Request $request){

        $users = HealthActivities::FindorFail($request->id);
        return view('admin.health.detail',compact('users'));
    }


    public function changeStatus(Request $request){

        $users = HealthActivities::FindorFail($request->id);
        $users->status = $request->status;
        $users->save();
    }


    public function search(Request $request){

      if($request->ajax()){

        $keyword = $request->keyword;

        if(empty($keyword)){
            
            $usersList = HealthActivities::where('user_type','!=','admin')->get();  
       
        }else{

          $usersList = HealthActivities::where(function ($query) use ($keyword) {
              $query->where('first_name','like', "%".$keyword ."%")
                ->orwhere('phone','like',"%".$keyword ."%")
                ->orwhere('email','like',"%".$keyword ."%");

          })->where('user_type','!=','admin')->get();  
        }
         
          
        return view('admin.health.search',compact('usersList'));
      }
  
    }
}
