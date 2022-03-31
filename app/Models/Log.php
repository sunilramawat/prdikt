<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Log extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "logs";
    protected $primaryKey = "id";
    protected $dates = ['deleted_at'];


   
}
