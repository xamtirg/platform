<?php
/*
	Автозагрузка фасада здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Base\Facades;

use Xamtirg\Base\Supports\BreadcrumbsManager;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Base\Supports\BreadcrumbsManager
 */
class BreadcrumbsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BreadcrumbsManager::class;
    }
}
