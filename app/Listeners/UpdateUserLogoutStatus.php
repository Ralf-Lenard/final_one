<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class UpdateUserLogoutStatus

{public function handle(Logout $event)
    {
        \Log::info('User logged out: ' . $event->user->id); // Log the user ID
    
        $user = $event->user;
        if ($user) {
            $user->is_online = false;
            $user->save();
        }
    }
    
}
