<?php
/*
	Автозагрузка провайдера здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Base\Providers;

use Xamtirg\Base\Commands\CleanupSystemCommand;
use Xamtirg\Base\Commands\ClearLogCommand;
use Xamtirg\Base\Commands\ExportDatabaseCommand;
use Xamtirg\Base\Commands\FetchGoogleFontsCommand;
use Xamtirg\Base\Commands\InstallCommand;
use Xamtirg\Base\Commands\PublishAssetsCommand;
use Xamtirg\Base\Commands\UpdateCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            ClearLogCommand::class,
            InstallCommand::class,
            UpdateCommand::class,
            PublishAssetsCommand::class,
            CleanupSystemCommand::class,
            ExportDatabaseCommand::class,
            FetchGoogleFontsCommand::class,
        ]);
    }
}
