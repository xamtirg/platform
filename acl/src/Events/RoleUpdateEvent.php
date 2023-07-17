<?php

namespace Xamtirg\ACL\Events;

use Xamtirg\ACL\Models\Role;
use Xamtirg\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RoleUpdateEvent extends Event
{
    use SerializesModels;

    public Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }
}
