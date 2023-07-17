<?php

namespace Xamtirg\Setting\Facades;

use Xamtirg\Setting\Supports\SettingStore;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\Setting\Supports\SettingStore
 */
class SettingFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SettingStore::class;
    }
}
