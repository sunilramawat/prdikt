<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Category;
use App\Models\User;
use App\Models\SleepData;
use App\Models\Log;
use App\Models\Activities;
use App\Models\FileResponse;
use App\Models\HealthActivities;
use App\Models\UserFile;
use App\Models\UserJob;
use App\Http\Controllers\Controller;
use App\Http\Utility\commonHelper;
use Carbon\Carbon;  
use DB;

class UsersController extends Controller
{
    
    public function index(){

       $usersList = User::where('user_type','!=','admin')->get(); 
       return view('admin.users.view',compact('usersList'));
    }


    public function edit(Request $request){

        $user = User::FindorFail($request->id); 
        return view('admin.users.edit',compact('user'));
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


        return redirect('/users')->with('success','User Edited successfully.');

    }


    public function delete(Request $request)
    {
        $users = User::FindorFail($request->id);
        $users->deleted_at = date('Y-m-d H:i:s');
        $users->save();
        return redirect('/users')->with('error','User Deleted successfully');
    }


    public function day_wise_time_spent_data(Request $request)
    {   
         $day_wise_time_spent = Log::select(['start','endtime',\DB::raw("sum(timestampdiff(second,start,endtime))as spennttime"),'action',\DB::raw("DATE(created_at) as created_at"),'uuid'])->whereDate('created_at', Carbon::today())
          ->where('uuid',$request->id)
          ->whereNotNull('endtime')
          ->groupBy('action',\DB::raw("DATE(created_at)"))
          ->orderBy('id')
          ->get();
         //echo '<pre>'; print_r($day_wise_time_spent); exit;
          

          
         $day_wise_time_spent_data = [];
     
         foreach($day_wise_time_spent as $actionrow) {
            //echo '<pre>'; print_r($actionrow);
            $day_wise_time_spent_data['label'][] = $actionrow->spennttime/60;
            $day_wise_time_spent_data['data'][] = $actionrow->action;
            //$actions_use_data['data'][] = $actionrow->created_at->todatestring();
          }
     
         $day_wise_time_spent_data['day_wise_time_spent_data'] = json_encode($day_wise_time_spent_data);

         return $day_wise_time_spent_data;
    }


    public function weekly_wise_time_spent_data(Request $request)
    {   
         $weekly_wise_time_spent = Log::select(['start','endtime',\DB::raw("sum(timestampdiff(second,start,endtime))as spennttime"),'action',\DB::raw("DATE(created_at) as created_at"),'uuid'])
            //->whereDate('created_at', Carbon::today())
            ->where('uuid',$request->id)
            ->whereNotNull('endtime')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            //->where('created_at', '>', Carbon::today()->subDay(6))
            ->where('uuid',$request->id)
            ->groupBy('action')
            ->orderBy('action')
              ->get();


         //echo '<pre>'; print_r($day_wise_time_spent); exit;
          

          
         $weekly_wise_time_spent_data = [];
     
         foreach($weekly_wise_time_spent as $actionrow) {
            //echo '<pre>'; print_r($actionrow);
            $weekly_wise_time_spent_data['label'][] = $actionrow->spennttime/60;
            $weekly_wise_time_spent_data['data'][] = $actionrow->action;
            //$actions_use_data['data'][] = $actionrow->created_at->todatestring();
          }
     
         $weekly_wise_time_spent_data['weekly_wise_time_spent_data'] = json_encode($weekly_wise_time_spent_data);

         return $weekly_wise_time_spent_data;
    }


    public function montly_wise_time_spent_data(Request $request){
         ///////////////////////////////////////////////////////////////////////


         $montly_wise_time_spent = Log::select(['start','endtime',\DB::raw("sum(timestampdiff(second,start,endtime))as spennttime"),'action',\DB::raw("DATE(created_at) as created_at"),'uuid'])
           ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            //->where('created_at', '>', Carbon::today()->subDay(6))
            ->where('uuid',$request->id)
             ->groupBy('action')
            ->orderBy('action')
            ->get();


            //echo '<pre>'; print_r($weekly_wise_time_spent); exit;
          

          
         $montly_wise_time_spent_data = [];
     
         foreach($montly_wise_time_spent as $actionrow) {
            //echo '<pre>'; print_r($actionrow);
            $montly_wise_time_spent_data['label'][] = $actionrow->action;
            $montly_wise_time_spent_data['data'][] = $actionrow->spennttime/60;
            //$actions_use_data['data'][] = $actionrow->created_at->todatestring();
          }
     
         $montly_wise_time_spent_data['montly_wise_time_spent_data'] = json_encode($montly_wise_time_spent_data);

      
         //////////////////////////////////////////////////////////////////////////
    }

  

    public function detail(Request $request){
        $users = User::FindorFail($request->id);
        $userId = $request->id;

        $sleep_time = HealthActivities::select(\DB::raw("sum(health_activities_minutes) as count"), \DB::raw("DAYNAME(health_activities_dates) as day_name"), \DB::raw("DAY(health_activities_dates) as day"))
        ->where('health_activities_dates', '>', Carbon::today()->subDay(6))
        ->where('health_activities_uuid',$request->id)
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
        
        //echo '<pre>'; print_r($sleep_time); exit;

         $chart_data_sleep = [];
     
         foreach($sleep_time as $row_sleep) {
            $chart_data_sleep['label'][] = ucfirst($row_sleep->day_name);
            $chart_data_sleep['data'][] = (int) $row_sleep->count;
          }
     
         $chart_data_sleep['chart_data_sleep'] = json_encode($chart_data_sleep);
         //echo '<pre>'; print_r($chart_data_sleep); exit;
         //////////////////////////////



        //////////////////////////////////////////////////////////
        $pcp = FileResponse::select('pcp_data as Data')
                    ->where('userId',$request->id)->get();
        $pcp_chart_data_new['pcp_chart_data_new'] = array();
            $pcp = json_decode($pcp);

        if(isset($pcp)){
           
            $pcp_chart_data['pcp_chart_data'] = json_decode(json_encode(@$pcp[0]->Data)); 
            ///echo '<pre>'; print_r($pcp_chart_data); //exit;
           
            foreach($pcp_chart_data as $pcpvalue){
                $tetpcp = json_decode($pcpvalue);
                $tetpcp_label = @$tetpcp->y;
                $tetpcp_data = @$tetpcp->x;
                //echo '<pre>'; print_r($tetpcp_data); exit;
                if(!empty($tetpcp_label)){    
                    foreach (@$tetpcp_label as $keypcp => $valuepcp) {
                        $pcp_chart_data_new['label'][] = $valuepcp;
                    }       
                    
                    foreach ($tetpcp_data as $keydatapcp => $valuedatapcp) {
                        $pcp_chart_data_new['data'][] = $valuedatapcp;
                    }
                }
            }

            //echo '<pre>'; print_r($pcp_chart_data_new); 
            //exit;
            $pcp_chart_data_new['pcp_chart_data_new'] = json_encode($pcp_chart_data_new);
        }
         
        //echo '<pre>'; print_r($pcp_chart_data_new); exit;

        ///////////////////////////////////////////////////////////



         //////////////////////////////////////////////////////////
        $sleeptime = FileResponse::select('plot_sleep_time as Data')
                    ->where('userId',$request->id)->get();
            $sleeptime = json_decode($sleeptime);
        $pst_chart_data_new['pst_chart_data_new'] = array();

        /*if(isset($sleeptime)){
           
            $pst_chart_data['pst_chart_data'] = json_decode(json_encode(@$sleeptime[0]->Data)); 
            ///echo '<pre>'; print_r($pst_chart_data); //exit;
           
            foreach($pst_chart_data as $pstvalue){
                $tetpst = json_decode($pstvalue);
                $dummypst_var = "Sleep Debt(Neg)";
                $tetpst_data = @$tetpst->plot_2->data_points->$dummypst_var;
                //echo '<pre>'; print_r($tetpst_data); exit;

                $tetpst_label = @$tetpst->plot_2->x;
                if(!empty($tetpst_label)){    
                    foreach (@$tetpst_label as $keypst => $valuepst) {
                        $pst_chart_data_new['label'][] = $valuepst;
                    }       
                    
                    foreach ($tetpst_data as $keydatapst => $valuedatapst) {
                        $pst_chart_data_new['data'][] = $valuedatapst;
                    }
                }
            }

            //echo '<pre>'; print_r($pst_chart_data_new); 
            //exit;
            $pst_chart_data_new['pst_chart_data_new'] = json_encode($pst_chart_data_new);
        }*/
         
        //$pst_chart_data_new['pst_chart_data_new'] = array();
        //echo '<pre>'; print_r($pst_chart_data_new); exit;

        ///////////////////////////////////////////////////////////



        //////////////////////////////////////////////////////////
        $daily_sleep_performance = FileResponse::select('daily_sleep_performance as Data')
                    ->where('userId',$request->id)->get();
        $dsp_chart_data_new['dsp_chart_data_new'] = array();
            $daily_sleep_performance = json_decode($daily_sleep_performance);

        if(isset($daily_sleep_performance)){
           
            $dsp_chart_data['dsp_chart_data'] = json_decode(json_encode(@$daily_sleep_performance[0]->Data)); 
            //echo '<pre>'; print_r($dsp_chart_data); //exit;
           
            foreach($dsp_chart_data as $dspvalue){
                $tet = json_decode($dspvalue);
                $tet_label = @$tet->Date;
                $dummy_var = "Daily Sleep Score";
                $tet_data = @$tet->$dummy_var;
                //echo '<pre>'; print_r($tet_data); exit;
                if(!empty($tet_label)){    
                    foreach (@$tet_label as $key => $value) {
                        $dsp_chart_data_new['label'][] = $value;
                    }       
                    
                    foreach ($tet_data as $keydata => $valuedata) {
                        $dsp_chart_data_new['data'][] = $valuedata;
                    }
                }
            }

            //echo '<pre>'; print_r($dsp_chart_data_new); 
            //exit;
            $dsp_chart_data_new['dsp_chart_data_new'] = json_encode($dsp_chart_data_new);
        }
         
        //echo '<pre>'; print_r($dsp_chart_data); exit;

        ///////////////////////////////////////////////////////////


        $daily_exercise_performance  = FileResponse::select('daily_exercise_performance  as Data')
                    ->where('userId',$request->id)->get();

        $dep_chart_data_new['dep_chart_data_new'] = array();
        $daily_exercise_performance = json_decode($daily_exercise_performance);

       
        $dep_chart_data['dep_chart_data'] = json_decode(json_encode(@$daily_exercise_performance[0]->Data)); 
        //echo '<pre>'; print_r($dep_chart_data); //exit;
       
        foreach($dep_chart_data as $depvalue){
            $tetdep = json_decode($depvalue);
            $tetdep_label = @$tetdep->Date;
            $dummydep_var = "Daily Ex Score";
            $tetdep_data = @$tetdep->$dummydep_var;
            //echo '<pre>'; print_r($tetdep_data); exit;
            if(!empty($tetdep_label)){    
                foreach ($tetdep_label as $key_dep => $value_dep) {
                    $dep_chart_data_new['label'][] = $value_dep;
                }       
                foreach ($tetdep_data as $keydata_dep => $valuedata_dep) {
                    $dep_chart_data_new['data'][] = $valuedata_dep;
                }
            }
        }

        //echo '<pre>'; print_r($dsp_chart_data_new); 
        //exit;
        $dep_chart_data_new['dep_chart_data_new'] = json_encode(@$dep_chart_data_new);
         
        //echo '<pre>'; print_r($dep_chart_data); exit;

        ///////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////
        $daily_ex_intensity  = FileResponse::select('daily_mod_ex_intensity  as Data')
                    ->where('userId',$request->id)->get();
        $dei_chart_data_new['dei_chart_data_new'] = array();

        $daily_ex_intensity = json_decode($daily_ex_intensity);

       
        $dei_chart_data['dei_chart_data'] = json_decode(json_encode(@$daily_ex_intensity[0]->Data)); 
        //echo '<pre>'; print_r($dei_chart_data); exit;
       
        foreach($dei_chart_data as $deivalue){
            $tetdei = json_decode($deivalue);
            $tetdei_label = @$tetdei->Date;
            $dummydei_var = "Moderate Ex Mins";
            $tetdei_data = @$tetdei->$dummydei_var;
            //echo '<pre>'; print_r($tetdei_data); exit;
            if(!empty($tetdei_label)){    
                foreach ($tetdei_label as $key => $value) {
                    $dei_chart_data_new['label'][] = $value;
                }       
                
                foreach ($tetdei_data as $keydatadei => $valuedatadei) {
                    $dei_chart_data_new['data'][] = $valuedatadei;
                }
            }
        }

        //echo '<pre>'; print_r($dei_chart_data_new); 
        //exit;
        $dei_chart_data_new['dei_chart_data_new'] = json_encode(@$dei_chart_data_new);
         
        //echo '<pre>'; print_r($dei_chart_data_new); exit;

        ///////////////////////////////////////////////////////////

        $getUsercsv = UserFile::where('userId',$request->id)
                    ->orderBy('createdDate','DESC')
                    ->first();
    

        $activities = new Activities;
        $getAllActivities = $activities->getAllActivitiesByUser($request->id);
        //secho '<pre>'; print_r($getAllActivities); exit;
        /*$today = '2022-02-25';//date('Y-m-d');
        $heartfileName = 'HEARTRATE_AUTO '.$userId.'-'.$today.'.csv';
        $heartPath     =  public_path()."/docs/".$heartfileName;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"".$heartPath."\"");
        $heartPath = readfile($heartPath);


        $sleepfileName = 'SLEEP - '.$userId.'-'.$today.'.csv';
        $sleepPath     =  public_path()."/docs/".$sleepfileName;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"".$sleepPath."\"");
        $sleepPath = readfile($sleepPath);


        $userfileName = 'USER - '.$userId.'-'.$today.'.csv';
        $userPath     =  public_path()."/docs/".$userfileName;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"".$userPath."\"");
        echo $userPath =readfile($userPath);

        exit;*/


        $healthList = HealthActivities::leftjoin('users','users.last_uuid','health_activities.health_activities_uuid')
            ->where('id',$request->id)
            ->get(); 
        
  

        ///////////////////////////////

        ////////////////////////////////
        $record = Log::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->where('uuid',$request->id)
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
        
        //echo '<pre>'; print_r($record); exit;

         $chart_data = [];
     
         foreach($record as $row) {
            $chart_data['label'][] = ucfirst($row->day_name);
            $chart_data['data'][] = (int) $row->count;
          }
     
         $chart_data['chart_data'] = json_encode($chart_data);
         //////////////////////////////


         ////////////////////////////
         $time_sepent_log = Log::select(['start','endtime',\DB::raw("sum(timestampdiff(second,start,endtime))as spennttime"),'action',\DB::raw("DATE(created_at) as created_at"),'uuid'])->whereDate('created_at', Carbon::today())
          ->where('uuid',$request->id)
          ->whereNotNull('endtime')
          ->groupBy('action',\DB::raw("DATE(created_at)"))
          ->orderBy('id')
          ->get();
         //echo '<pre>'; print_r($time_sepet_log); exit;
          

          
         $actions_use_data = [];
     
         foreach($time_sepent_log as $actionrow) {
            //echo '<pre>'; print_r($actionrow->created_at->todatestring());
            $actions_use_data['label'][] = intval($actionrow->spennttime/60);
            $actions_use_data['data'][] = $actionrow->action;
            //$actions_use_data['data'][] = $actionrow->created_at->todatestring();
          }
     
         $actions_use_data['actions_use_data'] = json_encode($actions_use_data);
         // echo '<pre>'; print_r($actions_use_data); exit;
         ///////////////////////////////////////



         //////////////////////////// Todays App use by all users Log
         $day_wise = Log::select([\DB::raw("COUNT(action) as count"),'action',\DB::raw("DATE(created_at) as created_at"),'uuid'])->whereDate('created_at', Carbon::today())
          ->where('uuid',$request->id)
          ->groupBy('action','uuid',\DB::raw("DATE(created_at)"))
          ->orderBy('id')
          ->get();
         //echo '<pre>'; print_r($actions_use); exit;
          
         $event_day_wise_row_data = [];
     
         foreach($day_wise as $event_day_wise_row) {
            //echo '<pre>'; print_r($actionrow->created_at->todatestring());
            $event_day_wise_row_data['label'][] = $event_day_wise_row->count;
            $event_day_wise_row_data['data'][] = ucfirst($event_day_wise_row->action);
            //$actions_use_data['data'][] = $actionrow->created_at->todatestring();
          }
     
         $event_day_wise_row_data['event_day_wise_row_data'] = json_encode($event_day_wise_row_data);
         //echo '<pre>'; print_r($event_day_wise_row_data); exit;
         ///////////////////////////////////////


        ////////////////////////////////
        $weekly_record = Log::select(\DB::raw("COUNT(action) as count"),'action')
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        //->where('created_at', '>', Carbon::today()->subDay(6))
        ->where('uuid',$request->id)
        ->groupBy('action')
        ->orderBy('action')
        ->get();
        
        //echo '<pre>'; print_r($weekly_record); exit;

         $chart_data_weekly = [];
     
         foreach($weekly_record as $weeklyrow) {
            $chart_data_weekly['label'][] = ucfirst($weeklyrow->action);
            $chart_data_weekly['data'][] = (int) $weeklyrow->count;
          }
     
         $chart_data_weekly['chart_data_weekly'] = json_encode($chart_data_weekly);
         //echo '<pre>'; print_r($chart_data_weekly); //exit;
         //////////////////////////////

         ////////////////////////////////
        $montly_record = Log::select(\DB::raw("COUNT(action) as count"),'action')
        ->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        //->where('created_at', '>', Carbon::today()->subDay(6))
        ->where('uuid',$request->id)
         ->groupBy('action')
        ->orderBy('action')
        ->get();
        
        //echo '<pre>'; print_r($montly_record); exit;

         $chart_data_montly = [];
     
         foreach($montly_record as $montlyrow) {
            $chart_data_montly['label'][] = ucfirst($montlyrow->action);
            $chart_data_montly['data'][] = (int) $montlyrow->count;
          }
     
         $chart_data_montly['chart_data_montly'] = json_encode($chart_data_montly);
         //echo '<pre>'; print_r($chart_data_weekly); exit;
         //////////////////////////////



         //////////////////////////// Todays ay_wise_time_spent_data
         ////////////////////////////
         $day_wise_time_spent = Log::select(['start','endtime',\DB::raw("sum(timestampdiff(second,start,endtime))as spennttime"),'action',\DB::raw("DATE(created_at) as created_at"),'uuid'])->whereDate('created_at', Carbon::today())
          ->where('uuid',$request->id)
          ->whereNotNull('endtime')
          ->groupBy('action',\DB::raw("DATE(created_at)"))
          ->orderBy('id')
          ->get();
         //echo '<pre>'; print_r($day_wise_time_spent); exit;
          

          
         $day_wise_time_spent_data = [];
     
         foreach($day_wise_time_spent as $actionrow) {
            //echo '<pre>'; print_r($actionrow);
            $day_wise_time_spent_data['label'][] = intval($actionrow->spennttime/60);
            $day_wise_time_spent_data['data'][] = ucfirst($actionrow->action);
            //$actions_use_data['data'][] = $actionrow->created_at->todatestring();
          }
     
         $day_wise_time_spent_data['day_wise_time_spent_data'] = json_encode($day_wise_time_spent_data);
         //echo '<pre>'; print_r($day_wise_time_spent_data); exit;

         //$day_wise_time_spent_data = $this->day_wise_time_spent_data($request->id);

         ///////////////////////////////////////////////////////////////////////


         $weekly_wise_time_spent = Log::select(['start','endtime',\DB::raw("sum(timestampdiff(second,start,endtime))as spennttime"),'action',\DB::raw("DATE(created_at) as created_at"),'uuid'])
            //->whereDate('created_at', Carbon::today())
            ->where('uuid',$request->id)
            ->whereNotNull('endtime')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            //->where('created_at', '>', Carbon::today()->subDay(6))
            ->where('uuid',$request->id)
            ->groupBy('action')
            ->orderBy('action')
              ->get();


            //echo '<pre>'; print_r($weekly_wise_time_spent); exit;
          

          
         $weekly_wise_time_spent_data = [];
     
         foreach($weekly_wise_time_spent as $actionrow) {
            //echo '<pre>'; print_r($actionrow);
            $weekly_wise_time_spent_data['label'][] = ucfirst($actionrow->action);
            $weekly_wise_time_spent_data['data'][] = intval($actionrow->spennttime/60);
            //$actions_use_data['data'][] = $actionrow->created_at->todatestring();
          }
     
         $weekly_wise_time_spent_data['weekly_wise_time_spent_data'] = json_encode($weekly_wise_time_spent_data);

         

         //////////////////////////////////////////////////////////////////////////

         ///////////////////////////////////////////////////////////////////////


         $montly_wise_time_spent = Log::select(['start','endtime',\DB::raw("sum(timestampdiff(second,start,endtime))as spennttime"),'action',\DB::raw("DATE(created_at) as created_at"),'uuid'])
           ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            //->where('created_at', '>', Carbon::today()->subDay(6))
            ->where('uuid',$request->id)
             ->groupBy('action')
            ->orderBy('action')
            ->get();


            //echo '<pre>'; print_r($weekly_wise_time_spent); exit;
          

          
         $montly_wise_time_spent_data = [];
     
         foreach($montly_wise_time_spent as $actionrow) {
            //echo '<pre>'; print_r($actionrow);
            $montly_wise_time_spent_data['label'][] = ucfirst($actionrow->action);
            $montly_wise_time_spent_data['data'][] = intval($actionrow->spennttime/60);
            //$actions_use_data['data'][] = $actionrow->created_at->todatestring();
          }
     
         $montly_wise_time_spent_data['montly_wise_time_spent_data'] = json_encode($montly_wise_time_spent_data);

      
         //////////////////////////////////////////////////////////////////////////
            //echo '<pre>'; print_r($chart_data_weekly); //exit;
       
            //echo '<pre>'; print_r($dsp_chart_data_new); exit;        


          return view('admin.users.detail', compact('pcp_chart_data_new','pst_chart_data_new','dsp_chart_data_new','dep_chart_data_new','dei_chart_data_new','healthList','users','getUsercsv','getAllActivities','chart_data','actions_use_data','event_day_wise_row_data','chart_data_weekly','chart_data_montly','day_wise_time_spent_data','weekly_wise_time_spent_data','montly_wise_time_spent_data'));
         //return view('admin.users.detail',compact('users','data'));
    }

    public function detail11(Request $request){

        $users = User::FindorFail($request->id);
        $customerArr = array();
        $customerArr1 = array();
        $supplierArr = array();
        $supplierArr1 = array();
        $charArr = array();
        $charArr1 = array();
        $range = Carbon::now()->subDays(6);
        $today =  Carbon::now();
        
       
        /*DB::raw('DATE(created_at) as date')*/
        $getData = Log::select('created_at as date')
                        ->where('created_at', '>=', $range)
                        ->groupBy('date')
                        ->where('uuid',$request->id)
                        ->get()->toArray();
       

      

        Log::whereDate('created_at', Carbon::today())->get(['action','created_at']);

        $yvalue =  array();
        $xvalue =  array();

        foreach($getData as $key => $value){
            $yvalue[] = $key;
        }

        foreach($getData as $key => $value){
            $xvalue[] = date('Y-m-d H:i:s',strtotime($value['date']) );
        }


               
        $plot_sleep_cons = FileResponse::select('plot_sleep_cons')
                    ->whereDate('createdDate',$today)
                    ->where('userId',$request->id)
                    ->orderBy('createdDate','DESC')
                    ->first();
   
            
        $pcp_data = FileResponse::select('pcp_data')
                    ->whereDate('createdDate',$today)
                    ->where('userId',$request->id)
                    ->orderBy('createdDate','DESC')
                    ->first();


             
        if(!empty($plot_sleep_cons)){
  

            $plot_sleep_cons_values = json_decode($plot_sleep_cons['plot_sleep_cons']);
            $x_value_plot_sleep_cons = $plot_sleep_cons_values->x_lables;
            $y_value_plot_sleep_cons = $plot_sleep_cons_values->y_labels;
            $data_points_plot_sleep_cons = $plot_sleep_cons_values->data_points;
            //echo  '<pre>'; print_r($plot_sleep_cons_values->x_lables); exit;
        }else{

            $y_value_plot_sleep_cons = '';
            $x_value_plot_sleep_cons = '';
            $data_points_plot_sleep_cons = '';

        }
       /* $graph_count = count($plot_sleep_cons_values->x_lables); 
        $dataPoints1 = array();
        foreach ($data_points_plot_sleep_cons as $key => $value) {
            //$sleepData['label'] = $plot_sleep_cons_values->$key['data_points'][$key]['upper'];
            $sleepData['label'] = str_replace(' ','',$plot_sleep_cons_values->x_lables[$key]);

            $sleepData['y'] = array(intval($value->upper),intval($value->lower));
            array_push($dataPoints1,$sleepData);
        }*/
        //        echo '<prr>'; print_r($sleep_grapArr); ;


        $dataPoints1 = array(
            array("label"=> "Solar Thermal", "y"=> array(174, 383)),
            array("label"=> "Wind offshore", "y"=> array(170, 270)),
            array("label"=> "Natural Gas", "y"=> array(178, 238)),
            array("label"=> "Solar PV", "y"=> array(98, 193)),
            array("label"=> "ICGC", "y"=> array(106, 136)),
            array("label"=> "Biomass", "y"=> array(90, 117)),
            array("label"=> "Nuclear", "y"=> array(92, 101)),
            array("label"=> "Conventional Coal", "y"=> array(87, 119)),
            array("label"=> "Hydro", "y"=> array(69, 107)),
            array("label"=> "Wind onshore", "y"=> array(66, 82)),
            array("label"=> "Geothermal", "y"=> array(44, 52))
        );

    /*     echo '<pre>'; print_r($dataPoints1);
         echo '<pre>'; print_r($dataPoints2);
           exit;
    */ //echo '<pre>'; print_r($plot_sleep_cons); exit;
        return view('admin.users.detail',compact(
            'users','yvalue','xvalue',
            'y_value_plot_sleep_cons',
            'x_value_plot_sleep_cons',
            'data_points_plot_sleep_cons','dataPoints1'));
       
    }


    public function changeStatus(Request $request){

        $users = User::FindorFail($request->id);
        $users->status = $request->status;
        $users->save();
    }


    public function search(Request $request){

      if($request->ajax()){

        $keyword = $request->keyword;

        if(empty($keyword)){
            
            $usersList = User::where('user_type','!=','admin')->get();  
       
        }else{

          $usersList = User::where(function ($query) use ($keyword) {
              $query->where('first_name','like', "%".$keyword ."%")
                ->orwhere('phone','like',"%".$keyword ."%")
                ->orwhere('email','like',"%".$keyword ."%");

          })->where('user_type','!=','admin')->get();  
        }
         
          
        return view('admin.users.search',compact('usersList'));
      }
  
    }

    public function Usercsv(Request $request)
    {
        $getUsercsv = UserFile::where('userId',$request->id)
                    ->orderBy('createdDate','DESC')
                    ->first();
    
        if(!empty($getUsercsv)){
            $userCSV = date('Y-m-d', strtotime($getUsercsv->created_at));
            $file_name = 'USER - '.$request->id.'-'.$userCSV.'.csv';
            $path = public_path().'/docs/'.$file_name;        
            
            header("Content-Description: File Transfer"); 
            header("Content-Type: application/octet-stream"); 
            header("Content-disposition: attachment; filename=\"".$file_name."\"");
            readfile ($path);
            exit;
        }
        return 1;

        
    }

    public function Sleepcsv(Request $request)
    {
        $getUsercsv = UserFile::where('userId',$request->id)
                    ->orderBy('createdDate','DESC')
                    ->first();
        if(!empty($getUsercsv)){
            $userCSV = date('Y-m-d', strtotime($getUsercsv->created_at));
            $file_name = 'SLEEP - '.$request->id.'-'.$userCSV.'.csv';
            $path = public_path().'/docs/'.$file_name;        
            
            header("Content-Description: File Transfer"); 
            header("Content-Type: application/octet-stream"); 
            header("Content-disposition: attachment; filename=\"".$file_name."\"");
            readfile ($path);
            exit;
        }
        return 1;

        
    }

    public function Heartcsv(Request $request)
    {
        $getUsercsv = UserFile::where('userId',$request->id)
                    ->orderBy('createdDate','DESC')
                    ->first();
    
        if(!empty($getUsercsv)){
            $userCSV = date('Y-m-d', strtotime($getUsercsv->created_at));
            $file_name = 'HEARTRATE_AUTO '.$request->id.'-'.$userCSV.'.csv';
            $path = public_path().'/docs/'.$file_name;        
            
            header("Content-Description: File Transfer"); 
            header("Content-Type: application/octet-stream"); 
            header("Content-disposition: attachment; filename=\"".$file_name."\"");
            readfile ($path);
            exit;
        }
        return 1;

        
    }

}
