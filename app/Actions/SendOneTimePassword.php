<?php

namespace App\Actions;

use App\Exceptions\OneTimePasswordThrottleException;
use App\Mail\OneTimePasswordMail;
use App\Models\OneTimePassword;
use Illuminate\Support\Facades\Mail;

class SendOneTimePassword
{
    /**
     * @throws OneTimePasswordThrottleException
     */
    public function handle(string $email): OneTimePassword
    {
        $user = (new GetUserFromEmail)->handle($email);
        [$otp, $code] = (new CreateOneTimePassword)->handle($user);

        Mail::to($user)->send(new OneTimePasswordMail($otp, $code));

        return $otp;
    }
}
