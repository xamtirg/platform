<?php

namespace Xamtirg\Media\Facades;

use Xamtirg\Media\RvMedia;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Media\RvMedia
 */
class RvMediaFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RvMedia::class;
    }
}
