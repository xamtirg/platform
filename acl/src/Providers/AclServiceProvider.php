<?php
/*
	Автозагрузка провайдера здесь: .\vendor\platform\composer.json
*/
namespace Xamtirg\ACL\Providers;

use Xamtirg\ACL\Http\Middleware\Authenticate;
use Xamtirg\ACL\Http\Middleware\RedirectIfAuthenticated;
use Xamtirg\ACL\Models\Activation;
use Xamtirg\ACL\Models\Role;
use Xamtirg\ACL\Models\User;
use Xamtirg\ACL\Repositories\Caches\RoleCacheDecorator;
use Xamtirg\ACL\Repositories\Eloquent\ActivationRepository;
use Xamtirg\ACL\Repositories\Eloquent\RoleRepository;
use Xamtirg\ACL\Repositories\Eloquent\UserRepository;
use Xamtirg\ACL\Repositories\Interfaces\ActivationInterface;
use Xamtirg\ACL\Repositories\Interfaces\RoleInterface;
use Xamtirg\ACL\Repositories\Interfaces\UserInterface;
use Xamtirg\Base\Traits\LoadAndPublishDataTrait;
use EmailHandler;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(UserInterface::class, function () {
            return new UserRepository(new User());
        });

        $this->app->bind(ActivationInterface::class, function () {
            return new ActivationRepository(new Activation());
        });

        $this->app->bind(RoleInterface::class, function () {
            return new RoleCacheDecorator(new RoleRepository(new Role()));
        });
    }

    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        $this->setNamespace('core/acl')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['general', 'permissions', 'email'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets()
            ->loadRoutes()
            ->loadMigrations();

        $this->garbageCollect();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id' => 'cms-core-role-permission',
                    'priority' => 2,
                    'parent_id' => 'cms-core-platform-administration',
                    'name' => 'core/acl::permissions.role_permission',
                    'icon' => null,
                    'url' => route('roles.index'),
                    'permissions' => ['roles.index'],
                ])
                ->registerItem([
                    'id' => 'cms-core-user',
                    'priority' => 3,
                    'parent_id' => 'cms-core-platform-administration',
                    'name' => 'core/acl::users.users',
                    'icon' => null,
                    'url' => route('users.index'),
                    'permissions' => ['users.index'],
                ]);

            /**
             * @var Router $router
             */
            $router = $this->app['router'];

            $router->aliasMiddleware('auth', Authenticate::class);
            $router->aliasMiddleware('guest', RedirectIfAuthenticated::class);
        });

        $this->app->booted(function () {
            config()->set(['auth.providers.users.model' => User::class]);

            EmailHandler::addTemplateSettings('acl', config('core.acl.email', []), 'core');

            $this->app->register(HookServiceProvider::class);
        });
    }

    /**
     * Garbage collect activations and reminders.
     *
     * @throws BindingResolutionException
     */
    protected function garbageCollect(): void
    {
        $config = $this->app->make('config')->get('core.acl.general');

        $this->sweep($this->app->make(ActivationInterface::class), Arr::get($config, 'activations.lottery', [2, 100]));
    }

    protected function sweep(ActivationInterface $repository, array $lottery): void
    {
        if ($this->configHitsLottery($lottery)) {
            try {
                $repository->removeExpired();
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }

    /**
     * Determine if the configuration odds hit the lottery.
     */
    protected function configHitsLottery(array $lottery): bool
    {
        return mt_rand(1, $lottery[1]) <= $lottery[0];
    }
}
