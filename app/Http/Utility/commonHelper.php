<?php

namespace App\Http\Utility;

use App\Models\Token;
use App\Models\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

final class commonHelper {
	
	public function imageUpload($image,$pathName){

		$fileName = $image->getClientOriginalName();
		$fileExtension = $image->getClientOriginalExtension();
		$fileName = 'image'.rand(11111, 99999) . '.' . $fileExtension;
		$destinationPath = 'public/images/'.$pathName;
		$upload_success = $image->move($destinationPath, $fileName);
		$images = $fileName;


		return $images;
	}	

    public function constant($msgId){
    	$msg = array();
    	$msg[200] = 'success';
    	$msg[400] = 'Invalid request.please check paramters';
    	$msg[401] = 'Unauthenicated user';
    	$msg[402] = 'Invalid login credentials.please try with different one';
    	$msg[403] = 'This email or phone already exist.please try with different one';
    	$msg[423] = 'Your account is either blocked or deleted by admin.please contact admin.';

    	$msg[601] = 'Invalid code or email entered.please try again';
    	$msg[602] = 'Activation Code is send in your email';
    	$msg[603] = 'Actvities updated successfully.';
    	$msg[604] = 'No records found.';
    	$msg[605] = 'Your Account Deleted successfully.';
    	$msg[606] = 'Your Profile updated successfully.';
    	$msg[607] = 'Your Feedback save successfully.';
    	$msg[608] = 'Register successfully';
    	$msg[609] = 'Your Health data saved successfully';
    	$msg[610] = 'Reset Account Code is send in your register mail';
    	$msg[611] = 'Delete Account Code is send in your register mail';
    	$msg[612] = 'Sucessfully Delete Account';
    	$msg[613] = 'Sucessfully Reset Account ';

    	if( isset($msg[$msgId]) ){
	        $message = $msg[$msgId];
	    }else{
	        $message = '';
	    }
	    return $message;
    }

    public function getImagePath($model){

    	return "/public/images/{$model}/";
    }


    public function arrayfilterByNullValues($data){
    	
    	$return = array_map(function($values){
		    return  is_null($values) ? "" : $values;
		},$data);

		return $return;
    }

    public function  generateRandomNumber(){
		$number = rand(1000 , 9999 );
		return $number;	
	}	


	public  function generateToken($length = 500){
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
	}	

	public function matchUserToken($token = NULL){

        $user = Token::where([ 'token' => $token,'token_revoked' => '1'])->first();
        return $user;                    

	}

	public function linkedInLogin($access_token){

		$ch = curl_init('https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,emailAddress,profilePicture(displayImage~:playableStreams))&oauth2_access_token=' . $access_token);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);        
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

	public function createLogs($data){
		$findLastLog = Log::where([ 'uuid' => $data[0]])
						->orderBy('id','DESC')
					   	->first();
		if(!empty($findLastLog->id)){	
			if($findLastLog->endtime == '' ){
			    $startTime = Carbon::parse($findLastLog->start);
			    $endTime = Carbon::parse($data[3]);
				$totalDuration = $endTime->diffForHumans($startTime);
				/*$start = strtotime($findLastLog->start); 
				$end = strtotime($data[3]); 

				$totaltime = ($end - $start)  ; 

				$hours = intval($totaltime / 3600);   
				$seconds_remain = ($totaltime - ($hours * 3600)); 

				$minutes = intval($seconds_remain / 60);   
				$seconds = ($seconds_remain - ($minutes * 60)); 

				$totalDuration = $hours:$minutes:$seconds; 
				*/
				//int($totalDuration);
			   	
				Log::where('id', $findLastLog->id)
				->where('uuid', $data[0])
		        ->update([
		           'endtime' => $data[3],
		           	'minutes_spend'	=> $totalDuration
		        ]);
		    }
	    }

		
		$logs = new Log();
		$logs->uuid 	= $data[0];
		$logs->action 	= $data[1];
		$logs->controller = $data[2];
		$logs->start = $data[3];
		$logs->save();

		return 1;
	}	
}
