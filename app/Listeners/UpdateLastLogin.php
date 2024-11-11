<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Carbon\Carbon;

class UpdateLastLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        \Log::info('User logged in: ' . $event->user->id); // Log the user ID
    
        $user = $event->user;
        $user->last_login_at = Carbon::now();
        $user->last_login_ip = request()->ip();
        $user->is_online = true;
        $user->save();
    }
    
}
