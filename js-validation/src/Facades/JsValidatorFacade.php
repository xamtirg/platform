<?php

namespace Xamtirg\JsValidation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Xamtirg\JsValidation\JsValidatorFactory
 */
class JsValidatorFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'js-validator';
    }
}
