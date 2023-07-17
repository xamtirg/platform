<?php

namespace Xamtirg\ACL\Repositories\Caches;

use Xamtirg\ACL\Repositories\Interfaces\RoleInterface;
use Xamtirg\Support\Repositories\Caches\CacheAbstractDecorator;

class RoleCacheDecorator extends CacheAbstractDecorator implements RoleInterface
{
    /**
     * {@inheritDoc}
     */
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
