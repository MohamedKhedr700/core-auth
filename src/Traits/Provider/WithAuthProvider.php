<?php

namespace Raid\Core\Auth\Traits\Provider;

use Illuminate\Foundation\AliasLoader;
use \Laravel\Sanctum\PersonalAccessToken;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\Auth\Authentication\Login\LoginProvider;

trait WithAuthProvider
{
    /**
     * Register config.
     */
    private function registerConfig(): void
    {
        $configResourcePath = glob(__DIR__.'/../../../config/*.php');

        foreach ($configResourcePath as $config) {

            $this->publishes([
                $config => config_path(basename($config)),
            ], 'config-auth');
        }
    }

    /**
     * Register helpers.
     */
    private function registerHelpers(): void
    {
        $helpers = glob(__DIR__.'/../../Helpers/*.php');

        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }

    /**
     * Register commands.
     */
    private function registerCommands(): void
    {
        $this->commands($this->commands);
    }

    /**
     * Register auth.
     */
    private function registerAuth(): void
    {
        $this->registerDefaultLoginProvider();
        $this->registerLoginProviderInterface();
    }

    /**
     * Register default login provider.
     */
    private function registerDefaultLoginProvider(): void
    {
        $this->app->singleton(LoginProvider::class, config('authentication.default_provider'));
    }

    /**
     * Register login provider interface.
     */
    private function registerLoginProviderInterface(): void
    {
        $this->app->singleton(LoginProviderInterface::class, LoginProvider::class);
    }

    /**
     * Register sanctum personal access token model.
     */
    private function registerPersonalAccessTokenModel(): void
    {
        $accessTokenModel = config('authentication.access_token_model', PersonalAccessToken::class);

        AliasLoader::getInstance()->alias(PersonalAccessToken::class, $accessTokenModel);
    }
}
