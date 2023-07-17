<?php
/*
	Автозагрузка провайдера здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Chart\Providers;

use Xamtirg\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Support\ServiceProvider;

class ChartServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('core/chart')
            ->loadAndPublishViews();
    }
}
