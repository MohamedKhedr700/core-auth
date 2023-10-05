<?php

namespace Raid\Core\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Raid\Core\Auth\Commands\CreateAuthManagerCommand;
use Raid\Core\Auth\Commands\CreateAuthModelCommand;
use Raid\Core\Auth\Commands\CreateAuthProviderCommand;
use Raid\Core\Auth\Commands\PublishAuthCommand;
use Raid\Core\Auth\Traits\Provider\WithAuthProvider;

class AuthServiceProvider extends ServiceProvider
{
    use WithAuthProvider;

    /**
     * The commands to be registered.
     */
    protected array $commands = [
        CreateAuthManagerCommand::class,
        CreateAuthModelCommand::class,
        CreateAuthProviderCommand::class,
        PublishAuthCommand::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerConfig();
        $this->registerHelpers();
        $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPersonalAccessTokenModel();
    }
}
