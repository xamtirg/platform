<?php
/*
	Автозагрузка провайдера здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Support\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        File::requireOnce(core_path('support/helpers/common.php'));
    }
}
