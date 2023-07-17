<?php
/*
	Автозагрузка провайдера здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Dashboard\Providers;

use Xamtirg\Base\Traits\LoadAndPublishDataTrait;
use Xamtirg\Dashboard\Models\DashboardWidget;
use Xamtirg\Dashboard\Models\DashboardWidgetSetting;
use Xamtirg\Dashboard\Repositories\Caches\DashboardWidgetCacheDecorator;
use Xamtirg\Dashboard\Repositories\Caches\DashboardWidgetSettingCacheDecorator;
use Xamtirg\Dashboard\Repositories\Eloquent\DashboardWidgetRepository;
use Xamtirg\Dashboard\Repositories\Eloquent\DashboardWidgetSettingRepository;
use Xamtirg\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Xamtirg\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/**
 * @since 17/07/2023 01:53 AM
 */
class DashboardServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(DashboardWidgetInterface::class, function () {
            return new DashboardWidgetCacheDecorator(
                new DashboardWidgetRepository(new DashboardWidget())
            );
        });

        $this->app->bind(DashboardWidgetSettingInterface::class, function () {
            return new DashboardWidgetSettingCacheDecorator(
                new DashboardWidgetSettingRepository(new DashboardWidgetSetting())
            );
        });
    }

    public function boot(): void
    {
        $this->setNamespace('core/dashboard')
            ->loadHelpers()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets()
            ->loadMigrations();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id' => 'cms-core-dashboard',
                    'priority' => 0,
                    'parent_id' => null,
                    'name' => 'core/base::layouts.dashboard',
                    'icon' => 'fa fa-home',
                    'url' => route('dashboard.index'),
                    'permissions' => [],
                ]);
        });
    }
}
