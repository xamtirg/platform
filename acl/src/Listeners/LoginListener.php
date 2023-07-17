<?php

namespace Xamtirg\ACL\Listeners;

use Xamtirg\ACL\Models\User;
use Illuminate\Auth\Events\Login;

class LoginListener
{
    public function handle(Login $event): void
    {
        if ($event->user instanceof User) {
            cache()->forget(md5('cache-dashboard-menu-' . $event->user->id));
        }
    }
}
