<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class SleepData extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "sleep_datas";
    protected $primaryKey = "id";
    protected $dates = ['deleted_at'];

   
}
