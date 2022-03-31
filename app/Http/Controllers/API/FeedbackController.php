<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Feedback;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Utility\commonHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Custom;
use App\Http\Requests\API\FeedbackRequest;
use URL;

class FeedbackController extends Controller
{
        
    use  ApiResponse;

    public $controllerName = 'FeedbackController';

    public function list(Request $request){

        $commonHelper = new commonHelper();
        $user = auth()->user();
        $feedback = new Feedback;
        $getFeedback = $feedback->getFeedbackByUser($user->id);

        $response = array();
        $feedbackImages = array();
        $array = array();

        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        if(!empty($getFeedback)){

            foreach(json_decode($getFeedback->feedback_image) as $image){
                    
                $feedbackImages = URL::to('/').$commonHelper->getImagePath('Feedback').$image;
                array_push($array,$feedbackImages);
            }
            
            $response['feedback_image']   = $array;
            $response['feedback_comment'] = $getFeedback->feedback_comment;
        }

        return $this->success($response,$commonHelper->constant(200));       
    }

    public function addFeedback(FeedbackRequest $request){

        $commonHelper = new commonHelper();
        $user = auth()->user();
      
        $files = [];
        $path = 'Feedback';

        $logs = [
            $user->id,
            $request->route()->getActionMethod(),
            $this->controllerName,
            date('Y-m-d H:i:s')
        ];

        $createLogs    = $commonHelper->createLogs($logs);

        $feedback = new Feedback;
        $feedback->feedback_comment = $request->comment;       
        $feedback->feedback_user_id = $user->id;    

        if($request->hasfile('image'))
        {  
            foreach($request->file('image') as $file)
            {   
               $saveImage = $commonHelper->imageUpload($file,$path);
               $files[] = $saveImage;  
            }
            
            $feedback->feedback_image   = json_encode($files);
        }
       
        $feedback->save();

        return $this->success(NULL,$commonHelper->constant(607));       

    }

   
    
}
