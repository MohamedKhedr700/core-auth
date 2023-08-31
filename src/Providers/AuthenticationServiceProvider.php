<?php

use Illuminate\Support\ServiceProvider;
use Raid\Core\Auth\Traits\Provider\WithAuthenticationProvider;

class AuthenticationServiceProvider extends ServiceProvider
{
    use WithAuthenticationProvider;

    /**
     * The commands to be registered.
     */
    protected array $commands = [];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerConfig();
        $this->registerHelpers();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerEvents();
    }
}