<?php
/*
	Автозагрузка провайдера здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Table\Providers;

use Xamtirg\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Support\ServiceProvider;

class TableServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('core/table')
            ->loadHelpers()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->publishAssets();
    }
}
