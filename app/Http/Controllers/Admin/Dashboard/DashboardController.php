<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Log;
use App\Http\Utility\commonHelper;
use Carbon\Carbon; 
use DB;

class DashboardController extends Controller
{

    public function index(){
        $modal      = "App\Models\User";
        $query = $modal::query();
        $query = $query->select('id','email','first_name','last_name','phone','user_status','is_subscribe')
                //->where('isdelete',0)
                ->where('user_status',1)
                ->where('user_type','!=',0)
                //->where('address.set_default','=',1)
                ->orderBy('id', 'DESC')
                //->join('address','jhi_user.id','address.user_id')
                ->count();

        $user_total_count = $query;


        //////////////////////////////// User Count day wise
        $record = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"),\DB::raw("DATE(created_at) as created_at"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->where('user_status',1)
        ->where('user_type','!=',0)
        ->groupBy('day_name','day',\DB::raw("DATE(created_at)"))
        ->orderBy('day')
        ->get();
        
        //echo '<pre>'; print_r($record); //exit;

         $chart_data = [];
     
         foreach($record as $row) {
            $chart_data['label'][] = ucfirst($row->day_name);//$row->created_at->todatestring();
            $chart_data['data'][] = (int) $row->count;
          }
     
         $chart_data['chart_data'] = json_encode($chart_data);
         //echo '<pre>'; print_r($chart_data); exit;
         //////////////////////////////

         //////////////////////////// Todays App use by all users Log
         $actions_use = Log::select([\DB::raw("COUNT(action) as count"),'action',\DB::raw("DATE(created_at) as created_at"),'uuid'])->whereDate('created_at', Carbon::today())
          ->groupBy('action','uuid',\DB::raw("DATE(created_at)"))
          ->orderBy('id')
          ->get();
         //echo '<pre>'; print_r($actions_use); exit;
          
         $actions_use_data = [];
     
         foreach($actions_use as $actionrow) {
            //echo '<pre>'; print_r($actionrow->created_at->todatestring());
            $actions_use_data['label'][] = $actionrow->count;
            $actions_use_data['data'][] = ucfirst($actionrow->action);
            //$actions_use_data['data'][] = $actionrow->created_at->todatestring();
          }
     
         $actions_use_data['actions_use_data'] = json_encode($actions_use_data);
        //echo '<pre>'; print_r($actions_use_data); exit;
         ///////////////////////////////////////

         $time_sepent_log = Log::select([\DB::raw("sum(timestampdiff(second,start,endtime))as spennttime")])
          ->whereNotNull('endtime')
          ->get();
         $time_sepent_log = intval($time_sepent_log[0]['spennttime']/60); 

         $record = Log::select(\DB::raw("COUNT(*) as count"))
        ->get(); 
        $activity_count = $record[0]['count'];     
        ////////////////////////////////////////////////

        ////////////////////////////////
        $gender = User::select(\DB::raw("COUNT(gender) as gender_count,gender"))
        ->whereNotNull('gender')
        ->groupBy('gender')
        ->orderBy('id')
        ->get();
        
        
        //echo '<pre>'; print_r($gender); exit;

         $gender_data = [];
     
         foreach($gender as $row) {
            $gender_data['label'][] = (int) $row->gender_count;
            $gender_data['data'][] =  $row->gender;
          }
     
         $gender_data['gender_data'] = json_encode($gender_data);
         //////////////////////////////
 
         ////////////////////////////////
        $age = User::select(\DB::raw("COUNT(d_o_b) as age_count,d_o_b"))
        ->whereNotNull('d_o_b')
        ->groupBy('d_o_b')
        ->orderBy('id')
        ->get();
        
        

         $age_data = [];
     
         foreach($age as $row) {
            $age_data['label'][] = (int) $row->age_count;
            $age_data['data'][] =  $row->d_o_b;
          }
     
         $age_data['age_data'] = json_encode($age_data);
         //////////////////////////////
        echo '<pre>'; print_r($age_data); exit;
 

        return view('admin.dashboard',compact('user_total_count','chart_data','actions_use_data','time_sepent_log','activity_count','gender_data','age_data'));
        
        //return view('admin.dashboard');
    }
}
