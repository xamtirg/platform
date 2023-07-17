<?php
/*
	Автозагрузка фасада здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Base\Facades;

use Xamtirg\Base\Supports\MetaBox;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Base\Supports\MetaBox
 */
class MetaBoxFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MetaBox::class;
    }
}
