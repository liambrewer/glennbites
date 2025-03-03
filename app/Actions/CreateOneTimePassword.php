<?php

namespace App\Actions;

use App\Enums\OneTimePasswordStatus;
use App\Exceptions\OneTimePasswordThrottleException;
use App\Models\OneTimePassword;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class CreateOneTimePassword
{
    /**
     * @return array{ OneTimePassword, string }
     *
     * @throws OneTimePasswordThrottleException
     */
    public function handle(User $user): array
    {
        $this->throttle($user);

        return $this->createOneTimePassword($user);
    }

    /**
     * @throws OneTimePasswordThrottleException
     */
    public function throttle(User $user): void
    {
        $thresholds = [
            ['limit' => 1, 'minutes' => 1],
            ['limit' => 3, 'minutes' => 5],
            ['limit' => 5, 'minutes' => 30],
        ];

        foreach ($thresholds as $threshold) {
            $count = $this->getOneTimePasswordCount($user, $threshold['minutes']);

            if ($count >= $threshold['limit']) {
                $remaining = $this->calculateRemainingTime($user, $threshold['minutes']);
                throw new OneTimePasswordThrottleException($remaining['minutes'], $remaining['seconds']);
            }
        }
    }

    private function getOneTimePasswordCount(User $user, int $minutes): int
    {
        return $user->oneTimePasswords()
            ->where('status', '!=', OneTimePasswordStatus::USED)
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    private function calculateRemainingTime(User $user, int $minutes): array
    {
        $earliestOneTimePassword = $user->oneTimePasswords()
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->orderBy('created_at', 'asc')
            ->first();

        if ($earliestOneTimePassword) {
            $availableAt = $earliestOneTimePassword->created_at->addMinutes($minutes);
            $remainingSeconds = now()->diffInSeconds($availableAt, false);

            return [
                'minutes' => floor($remainingSeconds / 60),
                'seconds' => $remainingSeconds % 60,
            ];
        }

        return ['minutes' => 0, 'seconds' => 0];
    }

    /**
     * @return array{ OneTimePassword, string }
     */
    private function createOneTimePassword(User $user): array
    {
        return DB::transaction(function () use ($user) {
            // 6 digit length numeric otp
            $code = str_pad((string) mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

            $this->invalidateActiveOneTimePasswords($user);

            $otp = $user->oneTimePasswords()->create([
                'code' => $code,
                'status' => OneTimePasswordStatus::ACTIVE,
                'ip_address' => Request::ip(),
            ]);

            return [$otp, $code];
        });
    }

    private function invalidateActiveOneTimePasswords(User $user): void
    {
        $user->oneTimePasswords()
            ->where('status', OneTimePasswordStatus::ACTIVE)
            ->update(['status' => OneTimePasswordStatus::SUPERSEDED]);
    }
}
