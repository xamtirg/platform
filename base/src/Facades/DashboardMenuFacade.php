<?php

namespace Xamtirg\Base\Facades;

use Xamtirg\Base\Supports\DashboardMenu;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Base\Supports\DashboardMenu
 */
class DashboardMenuFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DashboardMenu::class;
    }
}
