<?php

namespace Raid\Core\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Raid\Core\Auth\Commands\CreateAuthAccountableCommand;
use Raid\Core\Auth\Commands\CreateAuthAccountCommand;
use Raid\Core\Auth\Commands\CreateAuthChannelCommand;
use Raid\Core\Auth\Commands\CreateAuthModelCommand;
use Raid\Core\Auth\Commands\CreateAuthRuleCommand;
use Raid\Core\Auth\Commands\CreateAuthStepCommand;
use Raid\Core\Auth\Commands\CreateAuthWorkerCommand;
use Raid\Core\Auth\Commands\PublishAuthCommand;
use Raid\Core\Auth\Traits\Provider\WithAuthProvider;

class AuthServiceProvider extends ServiceProvider
{
    use WithAuthProvider;

    /**
     * The commands to be registered.
     */
    protected array $commands = [
        CreateAuthAccountableCommand::class,
        CreateAuthAccountCommand::class,
        CreateAuthChannelCommand::class,
        CreateAuthModelCommand::class,
        CreateAuthRuleCommand::class,
        CreateAuthStepCommand::class,
        CreateAuthWorkerCommand::class,
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
        $this->registerAuth();
    }
}
