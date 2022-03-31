<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject
{
    use  HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'status',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserByEmail($email){
      return User::where('email',$email)->where('user_status',1)->first();
    }


    public function getUserByCode($code){
        return User::where('forgot_password',$code)->first();
    }

    public function getUserByActivationCodeAndEmail ($code,$email){

        return User::where('activation_code',$code)->where('email',$email)->first();
    }


    public function getUserForResetDeleteAccount($code,$email,$type){
        
        if($type == "delete"){

            return User::where('delete_account_code',$code)->where('email',$email)->first();
        }

        if($type == "reset"){

            return User::where('reset_account_code',$code)->where('email',$email)->first();
        }

    }


    public function getUserById($Id){
        
        return User::where('id',$Id)->first();
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }


    public function getUserBySocialPlateform($socialId){

        return User::where('linkedin_id',$socialId)->where('user_type',2)->first();
    }
}
