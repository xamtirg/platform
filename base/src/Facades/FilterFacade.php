<?php
/*
	Автозагрузка фасада здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Base\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Base\Supports\Filter
 */
class FilterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'core:filter';
    }
}
