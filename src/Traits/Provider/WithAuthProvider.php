<?php

namespace Raid\Core\Auth\Traits\Provider;

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
            ], 'config');
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
     * Register sanctum personal access token model.
     */
    private function registerPersonalAccessTokenModel(): void
    {
        AliasLoader::getInstance()->alias(\Laravel\Sanctum\PersonalAccessToken::class, config('authentication.access_token_model'));
    }
}