<?php
/*
	Автозагрузка фасада здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Base\Facades;

use Xamtirg\Base\Supports\EmailHandler;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Base\Supports\EmailHandler
 */
class EmailHandlerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EmailHandler::class;
    }
}
