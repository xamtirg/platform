<?php

namespace Xamtirg\ACL\Events;

use Xamtirg\ACL\Models\Role;
use Xamtirg\ACL\Models\User;
use Xamtirg\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RoleAssignmentEvent extends Event
{
    use SerializesModels;

    public Role $role;

    public User $user;

    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
    }
}
