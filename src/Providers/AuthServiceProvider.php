<?php

namespace Raid\Core\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use PublishCommand;
use Raid\Core\Auth\Traits\Provider\WithAuthProvider;

class AuthServiceProvider extends ServiceProvider
{
    use WithAuthProvider;

    /**
     * The commands to be registered.
     */
    protected array $commands = [
        PublishCommand::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerConfig();
        $this->registerHelpers();
        $this->commands($this->commands);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPersonalAccessTokenModel();
    }
}
