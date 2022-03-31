<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class HealthActivities extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "health_activities";
    protected $primaryKey = "health_activities_id";
    protected $dates = ['deleted_at'];

    
    public function getLastActivitiesByUser($userId,$deviceId){
        $getLastActivities = HealthActivities::select('health_activities_id','health_activities_start_date','health_activities_end_date')
        ->where('health_activities_device_id',$deviceId)
        ->where('health_activities_uuid',$userId)
        ->where('health_activities_type','!=',3)
        ->orderBy('health_activities_end_date','DESC')
        ->first();

        return $getLastActivities;

    }

    public function getLastExerciseByUser($userId,$deviceId){
        $getLastActivities = HealthActivities::select('health_activities_id','health_activities_start_date','health_activities_end_date')
        ->where('health_activities_device_id',$deviceId)
        ->where('health_activities_uuid',$userId)
        ->where('health_activities_type',3)
        ->orderBy('health_activities_end_date','DESC')
        ->first();

        return $getLastActivities;

    }
    public function findSActivitiesByType($healthActivitiesType,$Device,$userId){

        /*$list = HealthActivities::select(' sum( TIMEDIFF( `health_activities_end_date`, `health_activities_start_date` ) ) as mytime')
                    ->where('health_activities_type', $healthActivitiesType)
                    ->where('health_activities_device', $Device)
                    //->where('user_id', $userId)
                    ->get();*/
        /*$list = DB::select("SELECT `health_activities_device_id`, sum( TIMEDIFF( `health_activities_end_date`, `health_activities_start_date` ) ) as mytime FROM health_activities");*/ 
        /*$list = DB::select("SELECT CONCAT(YEAR(created_at), '/', lpad(WEEK(created_at),2,'0')) AS month,  sum( TIMEDIFF( `health_activities_end_date`, `health_activities_start_date` ) ) as mytime FROM health_activities where created_at BETWEEN (NOW() - INTERVAL 4 WEEK) AND NOW() GROUP BY month ORDER BY month desc limit 4");*/
        $list = DB::select("SELECT tmp.hour, sum(tmp.click) AS click
        FROM
          (SELECT DISTINCT
            (hour(`health_activities_start_date`)) AS hour,
            sum( TIMEDIFF( `health_activities_end_date`, `health_activities_start_date` ) ) as click
          FROM health_activities
          WHERE DATE_FORMAT(`health_activities_start_date`, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 DAY),
                                                                                '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')
          GROUP BY hour(`health_activities_start_date`)
          UNION
          SELECT 1 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 2 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 3 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 4 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 5 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 6 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 7 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 8 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 9 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 10 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 11 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 12 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 13 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 14 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 15 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 16 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 17 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 18 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 19 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 20 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 21 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 22 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 23 AS hour, 0 AS click FROM health_activities
          UNION
          SELECT 24 AS hour, 0 AS click FROM health_activities) tmp
        GROUP BY tmp.hour");

        return $list;
        
    }
}
