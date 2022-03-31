<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function create(LoginRequest $request)
    {
        Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]);
        //dd(Auth::user());
        if(Auth::user()->user_type == 0){
            return redirect()->route('dashboard.index');
        }

        return redirect()->back()->with('error','Invalid login credentials.please try again');
    }


    public function forgotPassword()
    {
        return view('admin.Auth.forgot_password');
    }

    public function  doForgotPassword(ResetPasswordRequest $request)
    {
       $user = new User();
       $getUser = $user->getUserByEmail($request->get('email'));

       if($getUser){
          $custom = new Custom();
          $token = Str::random(100);
          $link = $custom->generateLinks($token);
          $custom->sendResetPasswordMail($link,$request->get('email'));

          $getUser->forgot_password = $token;
          $getUser->save();

          return  redirect()->route('forgot_password')->with('success','Reset Password link send successfully');
       }
        return redirect()->route('forgot_password')->with('error','Invalid email address.please try again');
    }

    public function  resetPassword()
    {
        return view('admin.Auth.reset_password');
    }

    public  function  doResetPassword(Request $request){
        $user = new User();
        $getUser = $user->getUserByToken($request->token);

        if($getUser){

            $getUser->password = Hash::make($request->get('newPassword'));
            $getUser->save();
        }

    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
