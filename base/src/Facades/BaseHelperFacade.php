<?php
/*
	Автозагрузка фасада здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Base\Facades;

use Xamtirg\Base\Helpers\BaseHelper;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Base\Helpers\BaseHelper
 */
class BaseHelperFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BaseHelper::class;
    }
}
