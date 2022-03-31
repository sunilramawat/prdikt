<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "token";
    protected $primaryKey = "token_id";
    protected $fillable = [
       
        'token_user_id',
        'token',
        'token_revoked',
    ];

    protected $dates = ['deleted_at'];


    public function getUserByToken($userId){
        return Token::where('token_user_id',$userId)->first();
    }
}
