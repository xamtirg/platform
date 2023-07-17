<?php
/*
	Автозагрузка провайдера здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\Base\Providers;

use Xamtirg\Base\Events\AdminNotificationEvent;
use Xamtirg\Base\Events\BeforeEditContentEvent;
use Xamtirg\Base\Events\CreatedContentEvent;
use Xamtirg\Base\Events\DeletedContentEvent;
use Xamtirg\Base\Events\SendMailEvent;
use Xamtirg\Base\Events\UpdatedContentEvent;
use Xamtirg\Base\Listeners\AdminNotificationListener;
use Xamtirg\Base\Listeners\BeforeEditContentListener;
use Xamtirg\Base\Listeners\CreatedContentListener;
use Xamtirg\Base\Listeners\DeletedContentListener;
use Xamtirg\Base\Listeners\SendMailListener;
use Xamtirg\Base\Listeners\UpdatedContentListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SendMailEvent::class => [
            SendMailListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
        ],
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
        BeforeEditContentEvent::class => [
            BeforeEditContentListener::class,
        ],
        AdminNotificationEvent::class => [
            AdminNotificationListener::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        Event::listen(['cache:cleared'], function () {
            File::delete([storage_path('cache_keys.json'), storage_path('settings.json')]);
        });
    }
}
