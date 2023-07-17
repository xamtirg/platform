<?php
/*
	Автозагрузка фасада здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Base\Facades;

use Xamtirg\Base\Supports\MacroableModels;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Base\Supports\MacroableModels
 */
class MacroableModelsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MacroableModels::class;
    }
}
