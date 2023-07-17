<?php

namespace Xamtirg\Base\Facades;

use Xamtirg\Base\Supports\PageTitle;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Base\Supports\PageTitle
 */
class PageTitleFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PageTitle::class;
    }
}
