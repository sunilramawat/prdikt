<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "feedback";
    protected $primaryKey = "feedback_id";
    protected $dates = ['deleted_at'];


    public function getFeedbackByUser($userId){

        $getFeedback = Feedback::where('feedback_user_id',$userId)->first();
        return $getFeedback;

    }

}
