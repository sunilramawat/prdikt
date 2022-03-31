<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occuption extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "occuption";
    protected $primaryKey = "occuption_id";
    protected $fillable = [
        'occuption_name',
        'occuption_image',
        'occuption_description',
    ];

    protected $dates = ['deleted_at'];
}
