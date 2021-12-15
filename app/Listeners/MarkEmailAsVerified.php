<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkEmailAsVerified
{
    public function __construct()
    {
    }

    public function handle(PasswordReset $event): void
    {
        $user = $event->user;

        if ($user->hasVerifiedEmail()) {
            return;
        }

        $user->markEmailAsVerified();
    }
}
