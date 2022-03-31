<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginFormRequest;
use App\Http\Requests\API\RegisterFormRequest;
use App\Http\Requests\API\ForgotPasswordRequest;
use App\Http\Requests\API\ResetPasswordRequest;
use App\Http\Requests\API\SocialLoginRequest;
use App\Http\Utility\commonHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Custom;
use Illuminate\Support\Str;
use App\Models\Token;
use App\Models\Activities;
use URL;
use DB;
use Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use App\Mail\sendEmail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{ 
    use  ApiResponse;
    public $controllerName = 'AuthController';

    public function socialLogin(SocialLoginRequest $request){

        $commonHelper = new commonHelper();
        $checkLinkedId = $commonHelper->linkedInLogin($request->access_token);
        if(!empty($checkLinkedId)){
            $checkLinkedId = json_decode($checkLinkedId, true);
            //echo '<pre>'; print_r($checkLinkedId['id']); exit;
            $request->linkedin_id = $checkLinkedId['id'];
            $request->first_name = @$checkLinkedId['firstName']['localized']['en_US'];
            $request->last_name = @$checkLinkedId['lastName']['localized']['en_US'];
            $request->photo = @$checkLinkedId['profilePicture']['displayImage~']['elements'][0]['identifiers'][0]['identifier'];
        }
        $userModal =  new User;
        $user = $userModal->getUserBySocialPlateform($request->linkedin_id);
        if(!empty($user)){

            $logs = [
                $user->id,
                $request->route()->getActionMethod(),
                $this->controllerName,
                date('Y-m-d H:i:s')
            ];
            $path = "users";
            $token = $commonHelper->generateToken();
            $userDetail['address'] = $user->address;
            $userDetail['bio'] = $user->bio;
            $userDetail['d_o_b'] = $user->d_o_b;
            $userDetail['email'] = $user->email;
            $userDetail['email_verified_at'] = $user->email_verified_at;
            $userDetail['first_name'] = $user->first_name;
            $userDetail['last_name'] = $user->last_name;
            $userDetail['gender'] = $user->gender;
            $userDetail['id'] = $user->id;
            $userDetail['user_type'] = $user->user_type;
            $userDetail['device_id'] = $user->device_id;
            $userDetail['device_type'] = $user->device_type;
            $userDetail['device_token'] = $user->device_token;
            $userDetail['id'] = $user->id;
            $userDetail['linkedin_id'] = $user->linkedin_id;
            $userDetail['photo'] = @$user->photo ? $user->photo:'';
            $userDetail['accessToken'] = $token;
            $this->tokenCreated($user->id,$token);

            $createLogs    = $commonHelper->createLogs($logs);
            $response = $commonHelper->arrayfilterByNullValues($userDetail);
            return $this->success($response,$commonHelper->constant(200));
        }

        $logs = [
            "1234",
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];
        $user  = new User();
        $token = $commonHelper->generateToken();
        $user->linkedin_id  = $request->linkedin_id;
        $user->email        = $request->email;
        $user->photo        = $request->photo;
        $user->user_type    = $request->user_type ? $request->user_type : 2;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->added_date   = date ( 'Y-m-d H:i:s' );
        $user->user_status  = 1;
        $user->is_approved  = 0;
        $user->activation_code = 5210;//$commonHelper->generateRandomNumber();
        $user->password     = hash::make(123456);
        $user->is_email_verified = 0;
        $user->is_phone_verified = 0;
        $user->device_id    = $request->device_id;
        $user->device_type  = $request->device_type;
        $user->last_login   = date ( 'Y-m-d H:i:s' );
        $user->token_id     = mt_rand(); 
        $user->created_at   = date ( 'Y-m-d H:i:s' );
        $user->updated_at   = date ( 'Y-m-d H:i:s' );
        $user->save();
         $user->accessToken = $token;
        $this->tokenCreated($user->id,$token);
        $createLogs    = $commonHelper->createLogs($logs);
        $response = $commonHelper->arrayfilterByNullValues($user->toArray());
        return $this->success($response,$commonHelper->constant(608));
        
    }

    public  function  register(RegisterFormRequest  $request){
     
        $commonHelper = new commonHelper();
        $user = new User();
        $checkUserExist = User::where('email',$request->email)->count();
        
        

        if($checkUserExist > 0 ){

           $getUser = $user->getUserByEmail($request->email);

           $user = User::FindorFail($getUser->id);
           $user->activation_code = $commonHelper->generateRandomNumber();
           $user->save(); 

            $logs = [
                $getUser->id,
                $request->route()->getActionMethod(),
                $this->controllerName,
                date('Y-m-d H:i:s')
            ];
            $createLogs    = $commonHelper->createLogs($logs);

            //$data = ['message' => 'Please, use the verfication code below to access Prdikt app: <br><br> '.$user->activation_code.'<br><br> if you did not request it, you can ignore this email or let us know.'];
            $data = ['message' => $user->activation_code];
            Mail::to($user->email)->send(new sendEmail($data));
           return $this->success(Null,$commonHelper->constant(602));
        }

        
        $user->email        = $request->email;
        $user->photo        = $request->photo;
        $user->user_type    = $request->user_type ? $request->user_type : 1;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->added_date   = date ( 'Y-m-d H:i:s' );
        $user->user_status  = 1;
        $user->is_approved  = 0;
        $user->activation_code = $commonHelper->generateRandomNumber();
        $user->password     = hash::make(123456);
        $user->is_email_verified = 0;
        $user->is_phone_verified = 0;
        $user->last_login   = date ( 'Y-m-d H:i:s' );
        $user->token_id     = mt_rand(); 
        $user->created_at   = date ( 'Y-m-d H:i:s' );
        $user->updated_at   = date ( 'Y-m-d H:i:s' );
        $user->save();

        $data = ['message' => 'Your Prdikt Verfication Code is '.$user->activation_code];
          Mail::to($user->email)->send(new sendEmail($data));
        return $this->success(Null,$commonHelper->constant(602));

    }
    public function verify(LoginFormRequest $request){

        $commonHelper = new commonHelper();
        $user = new User();
        $loginType = 0; 
        

        if($request->code){ 
            $loginType = 1;
            $getUser = $user->getUserByActivationCodeAndEmail($request->code,$request->email);
        }else{
            $loginType = 2;
            $getUser = $user->getUserByEmail($request->email);
        }

        if(!empty($getUser)){
        
            $user = User::FindorFail($getUser->id);
            $user->is_email_verified = 1;
            $user->activation_code = NULL;
            $user->save(); 


            $logs = [
                $getUser->id,
                $request->route()->getActionMethod(),
                $this->controllerName,
                date('Y-m-d H:i:s')
            ];

            $createLogs    = $commonHelper->createLogs($logs);   

            $token = $commonHelper->generateToken();
            if($user->user_type == 1){
                $userDetail['address'] = $user->address?$user->address:'';
                $userDetail['bio'] = $user->bio?$user->bio:'';
                $userDetail['d_o_b'] = $user->d_o_b?$user->d_o_b:'';
                $userDetail['email'] = $user->email?$user->email:'';
                $userDetail['email_verified_at'] = $user->email_verified_at;
                $userDetail['first_name'] = $user->first_name?$user->first_name:'';
                $userDetail['last_name'] = $user->last_name?$user->last_name:'';
                $userDetail['gender'] = $user->gender?$user->gender:'';
                $userDetail['id'] = $user->id;
                $userDetail['user_type'] = $user->user_type;
                $userDetail['device_id'] = $user->device_id;
                $userDetail['device_type'] = $user->device_type;
                $userDetail['device_token'] = $user->device_token;
                $userDetail['id'] = $user->id;
                $userDetail['linkedin_profile_url'] = $user->linkedin_profile_url?$user->linkedin_profile_url:'';
                $userDetail['height'] = $user->height;
                $userDetail['weight'] = $user->weight;
                $userDetail['last_heart_activity'] = $user->last_heart_activity;
                $userDetail['last_health_activity'] = $user->last_health_activity;
                $userDetail['login_type'] = $user->user_type;
                $userDetail['photo'] = @$user->photo? URL::to('/public/images/users/'.$user->photo):'';
                $userDetail['accessToken'] = $token;
                $this->tokenCreated($user->id,$token);

                //$userDetail = $commonHelper->arrayfilterByNullValues($userDetail->toArray());
                return $this->success($userDetail,$commonHelper->constant(200));
            }

        }
        
        if( $loginType == 1){
            return $this->error($commonHelper->constant(601));
        }

        return $this->error($commonHelper->constant(402));
    }


    public function  doForgotPassword(ForgotPasswordRequest $request)
    {
       $user = new User();
       $commonHelper = new commonHelper();
       $getUser = $user->getUserByEmail($request->get('email'));

        $logs = [
            1234,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

       if($getUser){
          $custom = new Custom();
          $code = rand (1000 , 9999 );
          $custom->sendResetPasswordMail($code,$request->get('email'));

          $getUser->forgot_password = $code;
          $getUser->save();

          return $this->success(NULL,$commonHelper->constant(200));
       
       }

      return $this->error($user,$commonHelper->constant(400));
       
    }

    public  function  doResetPassword(ResetPasswordRequest $request){
        $user = new User();
        $commonHelper = new commonHelper();
        $getUser = $user->getUserByCode($request->get('code'));

        $logs = [
            1234,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        if($getUser){

            $getUser->password = Hash::make($request->get('password'));
            $getUser->forgot_password = NULL;
            $getUser->save();

            return $this->success(NULL,$commonHelper->constant(200));
        }

        return $this->error($commonHelper->constant(601));

    }

    public function tokenCreated($userId,$token){

        $getUserByToken = Token::getUserByToken($userId);
      
        if( !empty($getUserByToken) ){

          $getUserByToken->token = $token;
          $getUserByToken->save();

        }else{
            $createdToken = new Token;
            $createdToken->token_user_id = $userId;
            $createdToken->token = $token;
            $createdToken->save();
        }
       
    }

    public function getProfile(Request $request){

        $commonHelper = new commonHelper();
        $user = auth()->user();

        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        $getProfile = User::getUserById($user->id);
        $userDetail['address'] = $getProfile->address?$getProfile->address:'';
        $userDetail['bio'] = $getProfile->bio?$getProfile->bio:'';
        $userDetail['d_o_b'] = $getProfile->d_o_b?$getProfile->d_o_b:'';
        $userDetail['email'] = $getProfile->email?$getProfile->email:'';
        $userDetail['email_verified_at'] = $getProfile->email_verified_at;
        $userDetail['first_name'] = $getProfile->first_name?$getProfile->first_name:'';
        $userDetail['last_name'] = $getProfile->last_name?$getProfile->last_name:'';
        $userDetail['gender'] = $getProfile->gender?$getProfile->gender:'';
        $userDetail['id'] = $getProfile->id;
        $userDetail['user_type'] = $getProfile->user_type;
        $userDetail['device_id'] = $getProfile->device_id?$getProfile->device_id:'';
        $userDetail['device_type'] = $getProfile->device_type?$getProfile->device_type:'';
        $userDetail['device_token'] = $getProfile->device_token?$getProfile->device_token:'';
        $userDetail['linkedin_profile_url'] = $getProfile->linkedin_profile_url?$getProfile->linkedin_profile_url:'';
        $userDetail['height'] = $getProfile->height?$getProfile->height:'';
        $userDetail['weight'] = $getProfile->weight?$getProfile->weight:'';
        $userDetail['last_heart_activity'] = $getProfile->last_heart_activity?$getProfile->last_heart_activity:'';
        $userDetail['last_health_activity'] = $getProfile->last_health_activity?$getProfile->last_health_activity:'';
        if($getProfile->user_type == 1){
            
            $userDetail['photo'] = @$getProfile->photo? URL::to('/public/images/users/'.$getProfile->photo):'';
        }else{
            $userDetail['photo'] = @$getProfile->photo? $getProfile->photo:'';

        }
        //$getLoggedProfile = $commonHelper->arrayfilterByNullValues($getProfile->toArray());
        return $this->success($userDetail,$commonHelper->constant(200));
        
    }
    
    public function editProfile(Request $request){

        $commonHelper = new commonHelper();
        $path = "users";
       
        if(!empty($request->photo)){
            $saveImage = $commonHelper->imageUpload($request->photo,$path);
        }else{
            $saveImage= NULL;
        }

        $user = auth()->user();
        $getProfile = User::getUserById($user->id);

        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        $getProfile->first_name = $request->first_name ?? $getProfile->first_name;
        $getProfile->last_name = $request->last_name ?? $getProfile->last_name;
        $getProfile->email     = $request->email  ?? $getProfile->email;
        $getProfile->gender    = $request->gender ?? $getProfile->gender;
        $getProfile->height    = $request->height ?? $getProfile->height;
        $getProfile->weight    = $request->weight ?? $getProfile->weight;
        $getProfile->linkedin_profile_url    = $request->linkedin_profile_url ?? $getProfile->linkedin_profile_url;
        $getProfile->d_o_b     = date('d-m-Y',strtotime($request->dob)) ?? $getProfile->d_o_b;
        isset($saveImage) ? $getProfile->photo = $saveImage : '';
        $getProfile->save();

        //$getProfile['photo'] = URL::to('/').$commonHelper->getImagePath($path).$getProfile->photo;
        
        $userDetail['address'] = $getProfile->address?$getProfile->address:'';
        $userDetail['bio'] = $getProfile->bio?$getProfile->bio:'';
        $userDetail['d_o_b'] = $getProfile->d_o_b?$getProfile->d_o_b:'';
        $userDetail['email'] = $getProfile->email?$getProfile->email:'';
        $userDetail['email_verified_at'] = $getProfile->email_verified_at;
        $userDetail['first_name'] = $getProfile->first_name?$getProfile->first_name:'';
        $userDetail['last_name'] = $getProfile->last_name?$getProfile->last_name:'';
        $userDetail['gender'] = $getProfile->gender?$getProfile->gender:'';
        $userDetail['id'] = $getProfile->id;
        $userDetail['height'] = $getProfile->height;
        $userDetail['weight'] = $getProfile->weight;
        $userDetail['last_heart_activity'] = $getProfile->last_heart_activity;
        $userDetail['last_health_activity'] = $getProfile->last_health_activity;
        $userDetail['user_type'] = $getProfile->user_type;
        $userDetail['device_id'] = $getProfile->device_id?$getProfile->device_id:'';
        $userDetail['device_type'] = $getProfile->device_type?$getProfile->device_type:'';
        $userDetail['device_token'] = $getProfile->device_token?$getProfile->device_token:'';
        $userDetail['linkedin_profile_url'] = $getProfile->linkedin_profile_url?$getProfile->linkedin_profile_url:'';
        if($getProfile->user_type == 1){
            
            $userDetail['photo'] = @$getProfile->photo? URL::to('/public/images/users/'.$getProfile->photo):'';
        }else{
            $userDetail['photo'] = @$getProfile->photo? $getProfile->photo:'';

        }    
        
        //$user = $commonHelper->arrayfilterByNullValues($getProfile->toArray());

        return $this->success($userDetail,$commonHelper->constant(606));
    } 



    public function sendResetDeleteOtp(Request $request){
     
        $commonHelper = new commonHelper();
        $user = auth()->user();    

        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);
        
        $getUser = User::getUserById($user->id);
        $code = $commonHelper->generateRandomNumber();
        

        if($request->type == "delete"){
            $message = "Your Prdikt Otp To Delete Your Account is ".$code;
            $getUser->delete_account_code = $code;
            $successMsg = $commonHelper->constant(611);
        }

        if($request->type == "reset"){
            $message = "Your Prdikt Otp To Reset Your Account is ".$code;
            $getUser->reset_account_code = $code;
            $successMsg = $commonHelper->constant(610);
        }

        $getUser->save();   


        $data = ['message' => $message];
        Mail::to($user->email)->send(new sendEmail($data));

        return $this->success(NULL,$successMsg);
    }


    public function deleteOrResetAccount(Request $request){

        $commonHelper = new commonHelper();
        $user = auth()->user();
        
        $getOTP = $request->code;

        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];
        $createLogs    = $commonHelper->createLogs($logs);

        $getUser = User::getUserById($user->id);
        $wantToDeleteOrResetUser = User::getUserForResetDeleteAccount($getOTP,$getUser->email,$request->type);


        if($request->type == "delete"){
            
            $getUser =  User::getUserById($wantToDeleteOrResetUser->id);
            $getUser->deleted_at = date('Y-m-d H:i:s');
            $getUser->delete_account_code = NULL;
            $getUser->save();

            $successMsg = $commonHelper->constant(612);
        }

        if($request->type == "reset"){
            
            $getUser =  Activities::where('activities_user_id',$wantToDeleteOrResetUser->id)->get();

        
            foreach($getUser as $user){
                Activities::where('activities_user_id',$user->id)->delete();
            }

            $getUser =  User::getUserById($wantToDeleteOrResetUser->id);
            $getUser->reset_account_code = NULL;
            $getUser->save();


            $successMsg = $commonHelper->constant(613);
        }
        
       

        return $this->success(NULL,$successMsg);
    }

    public function trems(){
         $commonHelper = new commonHelper();
         $user = auth()->user();
         $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);
         $result = DB::table('pages')->where('p_status','=',1)->where('id','=',1)->first();
           print_r($result->p_description);
    }


    public function checkpy(){
      
        $commonHelper = new commonHelper();
        $process = new Process(['python', '/public/image/Prdikt_Alg_V2-2.py']);
        $process->run();
        $user = auth()->user();
        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }

    public function pywebhook(Request $request){
        $commonHelper = new commonHelper();
        $user = auth()->user();
        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);
        echo request()->route()->getActionMethod();

        dd($request); exit;
       
    }


    public function uploadHealthCsv(){

        $headers = array("Content-Type:multipart/form-data");
        $basePath = public_path().'/public/docs/'; 
       
        $path1  = $basePath.'SLEEP.csv';
        $path2  = $basePath.'USER.csv';
        $path3  = $basePath.'HEARTRATE_AUTO.csv';
        

        $dir1 = $path1; // full directory of the file
        $dir2 = $path2; // full directory of the file
        $dir3 = $path2;

        $cFile1 = curl_file_create($dir1);  
        $cFile2 = curl_file_create($dir2);  
        $cFile3 = curl_file_create($dir3);  

        $post = array(
            "sleep_csv" => $cFile1,
            "age_csv"   => $cFile2,
            "ex_csv"    => $cFile3

        ); // Parameter to be sent

        $target_url = "http://3.133.35.108:3001/api/v1/upload/files";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result= curl_exec($ch);
        curl_close ($ch);

        dd($result);
    }

    
}
