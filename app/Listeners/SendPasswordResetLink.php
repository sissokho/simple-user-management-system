<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Password;

class SendPasswordResetLink implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle(UserCreated $event): void
    {
        Password::sendResetLink(
            ['email' => $event->user->email]
        );
    }
}
