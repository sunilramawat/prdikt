<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activities extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "activities";
    protected $primaryKey = "activities_id";
    protected $dates = ['deleted_at'];


    public function getActivitiesByUser($type,$userId){

        $getActivities = Activities::where('activities_user_id',$userId)
                        ->where('activities_type',$type)->first();

        return $getActivities;

    } 

    public function getAllActivitiesByUser($userId){

        $getAllActivities = Activities::where('activities_user_id',$userId)->first();

        return $getAllActivities;

    }

    

}


