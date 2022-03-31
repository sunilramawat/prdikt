<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileResponse extends Model
{
    use HasFactory;

    protected $table = "fileresponse";
    protected $primaryKey = "id";

}
