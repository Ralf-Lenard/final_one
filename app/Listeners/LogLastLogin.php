<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LogLastLogin
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // Log the user's login for debugging
        Log::info('User logged in: ' . $event->user->id);

        // Update the last login timestamp and IP address
        User::where('id', $event->user->id)->update([
            'last_login_at' => now(), // Sets the current timestamp
            'last_login_ip' => request()->ip(), // Captures the user's IP address
        ]);
    }
}
