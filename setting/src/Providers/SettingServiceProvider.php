<?php

namespace Xamtirg\Setting\Providers;

use Xamtirg\Base\Traits\LoadAndPublishDataTrait;
use Xamtirg\Setting\Facades\SettingFacade;
use Xamtirg\Setting\Models\Setting as SettingModel;
use Xamtirg\Setting\Repositories\Caches\SettingCacheDecorator;
use Xamtirg\Setting\Repositories\Eloquent\SettingRepository;
use Xamtirg\Setting\Repositories\Interfaces\SettingInterface;
use Xamtirg\Setting\Supports\SettingsManager;
use Xamtirg\Setting\Supports\SettingStore;
use EmailHandler;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    protected bool $defer = true;

    public function register(): void
    {
        $this->setNamespace('core/setting')
            ->loadAndPublishConfigurations(['general']);

        $this->app->singleton(SettingsManager::class, function (Application $app) {
            return new SettingsManager($app);
        });

        $this->app->singleton(SettingStore::class, function (Application $app) {
            return $app->make(SettingsManager::class)->driver();
        });

        AliasLoader::getInstance()->alias('Setting', SettingFacade::class);

        $this->app->bind(SettingInterface::class, function () {
            return new SettingCacheDecorator(
                new SettingRepository(new SettingModel())
            );
        });

        $this->loadHelpers();
    }

    public function boot(): void
    {
        $this
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadAndPublishConfigurations(['permissions', 'email'])
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id' => 'cms-core-settings',
                    'priority' => 998,
                    'parent_id' => null,
                    'name' => 'core/setting::setting.title',
                    'icon' => 'fa fa-cogs',
                    'url' => route('settings.options'),
                    'permissions' => ['settings.options'],
                ])
                ->registerItem([
                    'id' => 'cms-core-settings-general',
                    'priority' => 1,
                    'parent_id' => 'cms-core-settings',
                    'name' => 'core/base::layouts.setting_general',
                    'icon' => null,
                    'url' => route('settings.options'),
                    'permissions' => ['settings.options'],
                ])
                ->registerItem([
                    'id' => 'cms-core-settings-email',
                    'priority' => 2,
                    'parent_id' => 'cms-core-settings',
                    'name' => 'core/base::layouts.setting_email',
                    'icon' => null,
                    'url' => route('settings.email'),
                    'permissions' => ['settings.email'],
                ])
                ->registerItem([
                    'id' => 'cms-core-settings-media',
                    'priority' => 3,
                    'parent_id' => 'cms-core-settings',
                    'name' => 'core/setting::setting.media.title',
                    'icon' => null,
                    'url' => route('settings.media'),
                    'permissions' => ['settings.media'],
                ]);

            EmailHandler::addTemplateSettings('base', config('core.setting.email', []), 'core');
        });
    }

    public function provides(): array
    {
        return [
            SettingsManager::class,
            SettingStore::class,
        ];
    }
}
