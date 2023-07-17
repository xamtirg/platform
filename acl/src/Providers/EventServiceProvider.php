<?php

namespace Xamtirg\ACL\Providers;

use Xamtirg\ACL\Events\RoleAssignmentEvent;
use Xamtirg\ACL\Events\RoleUpdateEvent;
use Xamtirg\ACL\Listeners\LoginListener;
use Xamtirg\ACL\Listeners\RoleAssignmentListener;
use Xamtirg\ACL\Listeners\RoleUpdateListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RoleUpdateEvent::class => [
            RoleUpdateListener::class,
        ],
        RoleAssignmentEvent::class => [
            RoleAssignmentListener::class,
        ],
        Login::class => [
            LoginListener::class,
        ],
    ];
}
