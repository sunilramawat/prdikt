<?php

namespace App\Helpers;

use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class Custom
{
    public function generateLinks($token): string
    {
        return 'http://localhost/reset-password/'.$token;
    }

    public function sendResetPasswordMail($link,$email){
        $details = [
            'title' => 'Mail from PCOCI',
            'body' => 'Your requested to reset your password.Here your reset password code ',
            'link' => $link
        ];

        Mail::to($email)->send(new ResetPasswordMail($details));
    }
}
