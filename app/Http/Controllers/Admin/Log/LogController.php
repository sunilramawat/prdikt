<?php

namespace App\Http\Controllers\Admin\Log;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Log;
use App\Http\Controllers\Controller;
use App\Http\Utility\commonHelper;

class LogController extends Controller
{
    
    public function index(Request $request){
       $logList = Log::leftjoin('users','users.last_uuid','logs.uuid')
       ->get(); 
       //echo '<pre>'; print_r($logList); exit;
       return view('admin.log.view',compact('logList'));
    }



    public function delete(Request $request)
    {
        $users = Log::FindorFail($request->id);
        //$users->deleted_at = date('Y-m-d H:i:s');
        $users->save();
        return redirect('/log')->with('error','User Deleted successfully');
    }


    public function detail(Request $request){

        $users = Log::FindorFail($request->id);
        return view('admin.log.detail',compact('users'));
    }

    public function userlog(Request $request){

       $logList = Log::leftjoin('users','users.last_uuid','logs.uuid')
       ->where('logs.uuid',$request->id)
       ->orderBy('logs.id','DESC')
       ->get(); 
       //echo '<pre>'; print_r($logList); exit;
       return view('admin.log.view',compact('logList'));
    }


    public function changeStatus(Request $request){

        $users = Log::FindorFail($request->id);
        $users->status = $request->status;
        $users->save();
    }


    
}
