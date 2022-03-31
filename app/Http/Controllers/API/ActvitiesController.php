<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activities;
use App\Models\HealthActivities;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\EditActivitiesRequest;
use App\Http\Utility\commonHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Custom;
use URL;
use App\Models\UserFile;
use App\Models\UserJob;
use App\Models\FileResponse;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;

class ActvitiesController extends Controller
{
        
    use ApiResponse;
    public $controllerName = 'FeedbackController';

    public function activitiesList(EditActivitiesRequest $request){

        $commonHelper = new commonHelper();
        $activities = new Activities;
        $user = auth()->user();
        $getActivities = $activities->getAllActivitiesByUser($user->id);

        $logs = [
            $user->id ,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        $response = array();
        if(!empty($getActivities)){
                $response['avg_bed_time'] = @$getActivities->activities_avg_bed_time?$getActivities->activities_avg_bed_time:'';
                $response['avg_wake_up']  = @$getActivities->activities_avg_wake_up?$getActivities->activities_avg_wake_up:'';
                $response['target_sleep'] =  @$getActivities->activities_target_sleep?$getActivities->activities_target_sleep:'';
            

            
                $response['execrise_goal']    = @$getActivities->activities_execrise_goal?$getActivities->activities_execrise_goal:'';
                $response['avg_workout']      = @$getActivities->activities_avg_workout?$getActivities->activities_avg_workout:'';
                $response['execrise_session_per_week'] = 
            @$getActivities->activities_session_per_week?$getActivities->activities_session_per_week:'';
            

            
                $response['avg_mindfulness']       = @$getActivities->activities_avg_mindfulness?$getActivities->activities_avg_mindfulness:'';
                $response['mindfulness_goal']  = @$getActivities->activities_mindfulness_goal?$getActivities->activities_mindfulness_goal:'';
                $response['session_per_week']  = @$getActivities->activities_mindfulness_session_per_week?$getActivities->activities_mindfulness_session_per_week:'';
            
            return $this->success($response,$commonHelper->constant(200));
                //echo '<pre>'; print_r($response); exit;
        }    

        return $this->success($response,$commonHelper->constant(604));

    }


    public function editActvities(Request $request ){

        $commonHelper = new commonHelper();
        $activities = new Activities;
        $user = auth()->user();
        $getActivities = $activities->getAllActivitiesByUser($user->id);

        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        if(empty($getActivities)){
            $getActivities = new Activities;
        }   
        
        $getActivities->activities_user_id = $user->id;
        $getActivities->activities_type = $request->type;

        $logs = [
            1234,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        if($request->type === 'sleep'){
            
            $getActivities->activities_avg_bed_time = $request->avg_bed_time ??
            $getActivities->avg_bed_time; 

            $getActivities->activities_avg_wake_up = $request->avg_wake_up ?? 
            $getActivities->avg_wake_up; 


            $getActivities->activities_target_sleep = $request->target_sleep ??
            $getActivities->target_sleep;
            //echo '<pre>'; print_r($request->avg_bed_time); exit;
            $getActivities->save();
        }   


        if($request->type === 'exercise') {

            $getActivities->activities_avg_workout = $request->avg_workout ?? 
            $getActivities->activities_avg_workout;

            $getActivities->activities_execrise_goal = $request->execrise_goal??
            $getActivities->activities_execrise_goal;

            $getActivities->activities_session_per_week = $request->session_per_week ?? $getActivities->session_per_week;

            $getActivities->save();
        }


        if($request->type === 'mindfulness') {

            $getActivities->activities_avg_mindfulness =$request->avg_mindfulness ?? $getActivities->avg_mindfulness;
            
            $getActivities->activities_mindfulness_goal = $request->mindfulness_goal ?? $getActivities->mindfulness_goal;
        
            $getActivities->activities_mindfulness_session_per_week = $request->session_per_week ?? $getActivities->session_per_week;

            $getActivities->save();
        }  

        return $this->success(NULL,$commonHelper->constant(603));  

    }

    public function sleepData(Request $request){

        $healthData =  $request->health_activites;
        //echo '<per>'; print_r($healthData); exit;
        $healthActivities = new HealthActivities;
        $commonHelper = new commonHelper();
        $user = new User;
        $authUser = auth()->user();
        $healthArray = json_decode($healthData);

        $logs = [
            $authUser->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);


        foreach($healthArray as $key => $value){
            $healthActivities = new healthActivities();
            $healthActivities->health_activities_start_date = @$value->startDate ?? NULL;
            $healthActivities->health_activities_end_date = @$value->endDate ?? NULL;
            $healthActivities->health_activities_dates = @$value->dates ?? NULL;
            $healthActivities->health_activities_uuid = auth()->user()->id ?? NULL;
            $healthActivities->health_activities_device = @$value->device ?? NULL;
            $healthActivities->health_activities_deviceType = @$value->deviceType ?? NULL;
            $healthActivities->health_activities_deviceName = @$value->deviceName ?? NULL;
            $healthActivities->health_activities_minutes  = @$value->minutes ?? NULL;
            $healthActivities->health_activities_device_id  = @$value->deviceUnquieId ?? NULL;
            $healthActivities->health_activities_type = @$value->type ?? NULL;
            $healthActivities->health_activities_source_name = @$value->sourceName?? NULL;
            $healthActivities->save();

            /*$users = User::FindorFail(auth()->user()->id );

            $users->last_health_activity = $value->endDate;
            $users->save();*/
        }
    

        $header = $request->header('Authorization');
        $token = $commonHelper->matchUserToken($header);
        $getUser = $user->getUserById($token->token_user_id);
        $getUser->last_uuid = $healthActivities->health_activities_uuid;
        $getUser->save(); 

        $this->generateCsvForHeathData($authUser->id);

        return $this->success(NULL,$commonHelper->constant(609));  

    }

    public function exerciseData(Request $request){

        $healthData =  $request->health_activites;
        //$healthActivities = new HeartActivities;
        $commonHelper = new commonHelper();

           $authUser = auth()->user();
     
        $logs = [
            $authUser->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        $user = new User;
        $healthArray = json_decode($healthData);
        //echo '<pre>'; print_r($healthArray); exit;
        foreach($healthArray as $key => $value){
            $healthActivities = new healthActivities();
            $healthActivities->health_activities_start_date = @$value->startDate ?? NULL;
            $healthActivities->health_activities_end_date = @$value->endDate ?? NULL;
            $healthActivities->health_activities_uuid = auth()->user()->id ?? NULL;
            $healthActivities->health_activities_device = @$value->device ?? NULL;
            $healthActivities->health_activities_deviceType = @$value->deviceType ?? NULL;
            $healthActivities->health_activities_deviceName = @$value->deviceName ?? NULL;
            $healthActivities->health_activities_device_id  = @$value->deviceUnquieId ?? NULL;
            $healthActivities->heartRate = @$value->heartRate ?? NULL;
            $healthActivities->health_activities_type = @$value->type ?? NULL;
            $healthActivities->health_activities_source_name = @$value->sourceName?? NULL;
            $healthActivities->save();

           /* $users = User::FindorFail(auth()->user()->id );

            $users->last_heart_activity = $value->endDate;
            $users->save();*/


        }

        $header = $request->header('Authorization');
        $token = $commonHelper->matchUserToken($header);
        $getUser = $user->getUserById($token->token_user_id);
        $getUser->last_uuid = $healthActivities->health_activities_uuid;
        $getUser->save();  

        $this->generateCsvForHeathData($authUser->id);

        return $this->success(NULL,$commonHelper->constant(609));  

    }

    public function sleepChart(Request $request){
        $commonHelper = new commonHelper();
        $user = auth()->user();
        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        $healthActivities = new HealthActivities;
        $healthActivitiesType =  $request->health_activities_type;
        $device =  $request->device;
        $Chips = $healthActivities->findSActivitiesByType($healthActivitiesType,$device,$user->id);

        $response = array();
        $feedbackImages = array();
        $array = array();

        if(!empty($Chips)){

            //echo '<pre>';print_r($Chips); exit;
            $response['hour'] = array();
            $response['sleep'] = array();
            foreach ($Chips as $userskey => $usersvalue) {
                $chatMonth = array();
                $chatCustomer = array();
                $chatMonth = $usersvalue->hour; 
                $chatCustomer = $usersvalue->click; 

                //array_push($customerArr['post'],$partner_array);
                $response['hour'][] = $chatMonth;
                $response['sleep'][] = $chatCustomer;
            }
            //$response['hours']   = $customerArr[];
            //$response['sleep']   =  $customerArr1[];
            //$response['feedback_comment'] = $getFeedback->feedback_comment;
           /* foreach(json_decode($getFeedback->feedback_image) as $image){
                    
                $feedbackImages = URL::to('/').$commonHelper->getImagePath('Feedback').$image;
                array_push($array,$feedbackImages);
            }
            
            $response['feedback_image']   = $array;
            $response['feedback_comment'] = $getFeedback->feedback_comment;*/
        }


        return $this->success($response,$commonHelper->constant(200));       
    }
    

    public function getlastData(Request $request){
        $deviceId =  $request->device_id;
        $commonHelper = new commonHelper();
        $healthActivities = new healthActivities;
        $user = auth()->user();
        
        $getActivities = $healthActivities->getLastActivitiesByUser($user->id,$deviceId);
        
        $getActivitiesExercise = $healthActivities->getLastExerciseByUser($user->id,$deviceId);

        //echo '<pre>'; print_r($getActivitiesExercise); exit;
        
        $response = array();
        $response['sleep_last'] = @$getActivities->health_activities_end_date ? $getActivities->health_activities_end_date:'';
        $response['exercise_last'] = @$getActivitiesExercise->health_activities_end_date ? $getActivitiesExercise->health_activities_end_date:'';

        return $this->success($response,$commonHelper->constant(200));       
    }
    public function checkPy__(Request $request){
        $path = '/var/www/html/prdkit/public/images';
        $commonHelper = new commonHelper();
        $user = auth()->user();
      
        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);
 
        $output = shell_exec($path.'/'."Final_Report_Generation_NB_Timestamp-DAY1REV-LATEST-Copy1.ipynb");
        echo '<pre>'; print_r($output); exit;
    }

    public function checkPy(Request $request){
        //$process = new Process('python /path/to/your_script.py');
        //This won't be handy when going to pass argument
        $arg = '';
        $path = '/var/www/html/prdkit/public/images/Prdikt_Alg_V2-2.py';
        $process = new Process(['python',$path]);
        $process->run();
        $commonHelper = new commonHelper();
        $user = auth()->user();
      
        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);
        dd($process);
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }

    public function generateCsvForHeathData($userId){

        //$userId = 5;
        $today = date('Y-m-d');
        
        //HEART RATE
        $excle_rows = 'date'."\t".
            'time'."\t".
            'sourceName'."\t".
            'heartRate'."\n";

        $heartQuery =  HealthActivities::where('health_activities_type',3)
                       ->where('health_activities_uuid',$userId)
                       ->get();

        foreach($heartQuery as $query){

            $HeartBeatDate  =  explode(" ",$query->health_activities_start_date);
            $startDate      =  $HeartBeatDate[0];
            $time           =  date('H:i',strtotime($HeartBeatDate[1]));
           

            $excle_rows.= $startDate."\t".
                          $time."\t".
                          $query->health_activities_source_name."\t".
                          $query->heartRate . "\n";
            

        }

        $fileName = 'HEARTRATE_AUTO '.$userId.'-'.$today.'.csv';
        $heartPath     =  public_path()."/docs/".$fileName;
        $handler = fopen($heartPath,'w');
        fwrite($handler,$excle_rows);
        fclose($handler);


        // SLEEP
        $excle_rows = 'date'."\t".
            'deepSleepTime'."\t".
            'shallowSleepTime'."\t".
            'wakeTime'."\t".
            'sourceName'."\t".
            'start'."\t".
            'stop'."\n";

        $sleepQuery =  HealthActivities::where('health_activities_type','<',4)
                       ->where('health_activities_uuid',$userId)
                       ->get();
        //dd($sleepQuery);
        foreach($sleepQuery as $query){
            $sleepBeatDate  =  explode(" ",$query->health_activities_start_date);
            $startDate      =  $sleepBeatDate[0];
            //$time           =  date('H:i',strtotime($sleepBeatDate[1]));
            $deepSleepTime = 0;
            $shallowSleepTime = 0;
            $sourceName = 0;
            $wakeTime = 0;
            if($query->health_activities_type == 0){
                $deepSleepTime = $query->health_activities_minutes;
                $deepSleepTime = $query->health_activities_minutes;
                $deepSleepTime = $query->health_activities_minutes ;
            }elseif($query->health_activities_type == 1){
                $shallowSleepTime = $query->health_activities_minutes;
            }else{
                $wakeTime = $query->health_activities_minutes;   
            }

            $excle_rows.= $query->health_activities_dates."\t".
                          $deepSleepTime."\t".
                          $shallowSleepTime."\t".
                          $wakeTime."\t".
                          $query->health_activities_source_name."\t".
                          $query->health_activities_start_date."\t".
                          $query->health_activities_end_date . "\n";
        

        }
        //dd($excle_rows);

        $fileName = 'SLEEP - '.$userId.'-'.$today.'.csv';
        $sleepPath     =  public_path()."/docs/".$fileName;
        $handler = fopen($sleepPath,'w');
        fwrite($handler,$excle_rows);
        fclose($handler);

        // USER
        $excle_rows = 'userId'."\t".
            'gender'."\t".
            'height'."\t".
            'weight'."\t".
            'nickName'."\t".
            'avatar'."\t".
            'birthday'."\n";

        $query =  User::getUserById($userId);

        $excle_rows.= $query->id."\t".
                    $query->gender."\t".
                    $query->height."\t".
                    $query->weight."\t".
                    $query->username."\t".
                    $query->photo."\t".
                    date('Y-m-d',strtotime($query->d_o_b)) . "\n";


        $fileName = 'USER - '.$userId.'-'.$today.'.csv';
        $userPath     =  public_path()."/docs/".$fileName;
        $handler = fopen($userPath,'w');
        fwrite($handler,$excle_rows);
        fclose($handler);

        
        // SAVE FILE PATH

        $userFile = new UserFile;
        $userFile->userId = $userId;
        $userFile->sleep_csv_path = $sleepPath;
        $userFile->user_csv_path  = $userPath;
        $userFile->heart_csv_path = $heartPath;
        $userFile->status = 0;
        $userFile->createdDate = date('Y-m-d H:i:s');
        $userFile->save();



        $userJob = new UserJob;
        $userJob->userId = $userId;
        $userJob->status = 0;
        $userJob->createdDate = date('Y-m-d H:i:s');
        $userJob->save();

        return 1;
    }


    public function createGraph(Request $request){

        $commonHelper = new commonHelper();
        $user = auth()->user();
        $today =  Carbon::now();
        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];
        $today = '2022-03-18';
        $createLogs    = $commonHelper->createLogs($logs);
        $response = array();
        $user->id = 32;
        if($request->graph_type == 'sleep_time_duration'){

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
         
             $query = json_encode($chart_data_sleep);
            
          
        }

        if($request->graph_type == 'daily_sleep_performance'){

            $query = FileResponse::select('daily_sleep_performance as Data')
                    ->whereDate('createdDate',$today)
                    ->where('userId',$user->id)->get();

          
        }

        if($request->graph_type == 'daily_exercise_performance'){
            
            $query = FileResponse::select('daily_exercise_performance as Data')
                    ->whereDate('createdDate',$today)
                     ->where('userId',$user->id)->get();
        }

        if($request->graph_type == 'daily_mod_ex_intensity'){

            $query = FileResponse::select('daily_mod_ex_intensity as Data')
                    ->whereDate('createdDate',$today)
                     ->where('userId',$user->id)->get();
            
        }

        if($request->graph_type == 'daily_vig_ex_intensity'){

            $query = FileResponse::select('daily_vig_ex_intensity as Data')
                    ->whereDate('createdDate',$today)
                     ->where('userId',$user->id)->get();
            
        }

        if($request->graph_type == 'total_daily_ex_mins'){

            $query = FileResponse::select('total_daily_ex_mins as Data')
                    ->whereDate('createdDate',$today)
                     ->where('userId',$user->id)->get();
            
        } 
       
        if($request->graph_type == 'pcp_data'){

            $query = FileResponse::select('pcp_data as Data')
                    ->whereDate('createdDate',$today)
                     ->where('userId',$user->id)->get();
            
        }
        if($request->graph_type == 'plot_sleep_time'){

            $query = FileResponse::select('plot_sleep_time as Data')
                    ->whereDate('createdDate',$today)
                     ->where('userId',$user->id)->get();
            
        }


        foreach($query as $value){

            $response[] = $value->Data;
        }


        return $this->success($response,$commonHelper->constant(200)); 
    }

     public function createGraphSleep(Request $request){

        $commonHelper = new commonHelper();
        $user = auth()->user();
        $today =  Carbon::now();
        $response = array();
       
         $request->id = 32;
       
            $sleep_time = HealthActivities::select('health_activities_start_date','health_activities_end_date' ,'health_activities_dates',\DB::raw("sum(health_activities_minutes) as count"), \DB::raw("DAYNAME(health_activities_dates) as day_name"), \DB::raw("DAY(health_activities_dates) as day"))
            ->where('health_activities_source_name', '!=', 'Mi Fit')
            ->where('health_activities_dates', '>', Carbon::today()->subDay(17))
            ->where('health_activities_uuid',$request->id)
            ->groupBy('day_name','day')
            ->orderBy('day')
            ->get();
            
            //echo '<pre>'; print_r($sleep_time); exit;

             $chart_data_sleep = [];
         
             foreach($sleep_time as $row_sleep) {
               //$chart_data_sleep['label'][] = date("d-m-Y", strtotime($row_sleep->health_activities_dates));
                $chart_data_sleep['start_date'][] = date("d-m-Y H:i", strtotime($row_sleep->health_activities_start_date));
                $chart_data_sleep['end_date'][] = date("d-m-Y H:i", strtotime($row_sleep->health_activities_end_date));
                $chart_data_sleep['x'][] =  date("d-m-Y", strtotime($row_sleep->health_activities_dates));;
                $chart_data_sleep['data'][] = (int) $row_sleep->count;
              }
         
            // $response = json_encode($chart_data_sleep);
            
          
        
       

         return $this->success($chart_data_sleep,$commonHelper->constant(200)); 
    }
}




