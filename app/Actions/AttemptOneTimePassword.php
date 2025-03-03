<?php

namespace App\Actions;

use App\Enums\OneTimePasswordStatus;
use App\Exceptions\OneTimePasswordAttemptException;
use App\Models\OneTimePassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class AttemptOneTimePassword
{
    /**
     * @throws OneTimePasswordAttemptException
     */
    public function handle(string $id, string $sid, string $code): OneTimePassword
    {
        $this->validateSignature();
        $this->validateSession($sid);

        $otp = OneTimePassword::findOrFail($id);

        $this->validateStatus($otp);
        $this->validateNotExpired($otp);
        $this->validateAttempts($otp);
        $this->validateCode($otp, $code);

        $otp->update(['status' => OneTimePasswordStatus::USED]);

        return $otp;
    }

    /**
     * @throws OneTimePasswordAttemptException
     */
    private function validateSignature(): void
    {
        if (!request()->hasValidSignature()) {
            if (!URL::signatureHasNotExpired(request())) {
                throw new OneTimePasswordAttemptException(OneTimePasswordStatus::SIGNATURE->errorMessage());
            }

            throw new OneTimePasswordAttemptException(OneTimePasswordStatus::SIGNATURE->errorMessage());
        }
    }

    /**
     * @throws OneTimePasswordAttemptException
     */
    private function validateSession(string $sid): void
    {
        if ($sid !== session()->getId()) {
            throw new OneTimePasswordAttemptException(OneTimePasswordStatus::SESSION->errorMessage());
        }
    }

    /**
     * @throws OneTimePasswordAttemptException
     */
    private function validateStatus(OneTimePassword $otp): void
    {
        if ($otp->status !== OneTimePasswordStatus::ACTIVE) {
            throw new OneTimePasswordAttemptException($otp->status->errorMessage());
        }
    }

    /**
     * @throws OneTimePasswordAttemptException
     */
    private function validateNotExpired(OneTimePassword $otp): void
    {
        $expiresBefore = now()->subMinutes(5);
        if ($otp->created_at->lt($expiresBefore)) {
            $otp->update(['status' => OneTimePasswordStatus::EXPIRED]);
            throw new OneTimePasswordAttemptException($otp->status->errorMessage());
        }
    }

    /**
     * @throws OneTimePasswordAttemptException
     */
    private function validateAttempts(OneTimePassword $otp): void
    {
        if ($otp->attempts >= 3) {
            $otp->update(['status' => OneTimePasswordStatus::ATTEMPTED]);
            throw new OneTimePasswordAttemptException($otp->status->errorMessage());
        }
    }

    /**
     * @throws OneTimePasswordAttemptException
     */
    private function validateCode(OneTimePassword $otp, string $code): void
    {
        if (!Hash::check($code, $otp->code)) {
            $otp->increment('attempts');
            throw new OneTimePasswordAttemptException(OneTimePasswordStatus::INVALID->errorMessage());
        }
    }
}
