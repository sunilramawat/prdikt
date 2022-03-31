<?php

namespace App\Http\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginRepository extends User{

	public function doLogin($email,$password){

		$auth = Auth::attempt(['email' => $email, 'password' => $password]);
	    if($auth == true){
            $user = Auth::user();
        }else{
	        $user = 0;
        }
        return $user;
    }

}
