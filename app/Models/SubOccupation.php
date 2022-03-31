<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubOccupation extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "sub_occuption";
    protected $primaryKey = "sub_occuption_id";
    protected $fillable = [
    
        'sub_occuption_occuption_id',
        'sub_occuption_name',
        'sub_occuption_image',
        'sub_occuption_description',
    ];

    protected $dates = ['deleted_at'];
}
