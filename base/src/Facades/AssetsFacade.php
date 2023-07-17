<?php
/*
	Автозагрузка фасада здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Base\Facades;

use Xamtirg\Base\Supports\Assets;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Base\Supports\Assets
 */
class AssetsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Assets::class;
    }
}
