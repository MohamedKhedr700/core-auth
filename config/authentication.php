<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Login Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default login provider that will be used.
    | The provider is used to determine which login provider should be used
    | while authenticating accounts.
    |
    */

    'default_login_manager' => \Raid\Core\Auth\Authentication\Login\SystemLogin\SystemLoginProvider::class,


    /*
    |--------------------------------------------------------------------------
    | Access Token Model
    |--------------------------------------------------------------------------
    |
    | This option allows you to specify the model that should be used to
    | represent the personal access token. You may use your own custom
    | model here as long as it extends the Sanctum token model.
    |
    */

    'access_token_model' => \Raid\Core\Auth\Models\AccessToken\AccessToken::class,

    /*
    |--------------------------------------------------------------------------
    | Provider Managers
    |--------------------------------------------------------------------------
    |
    | Here you can define the login provider managers that will be used in the application.
    |
    */

    'manager_workers' => [
        \Raid\Core\Auth\Authentication\Login\DeviceLogin\DeviceLoginProvider::PROVIDER => [
            \Raid\Core\Auth\Authentication\Login\DeviceLogin\Managers\DeviceIdLoginManager::class,
        ],
        \Raid\Core\Auth\Authentication\Login\SystemLogin\SystemLoginProvider::PROVIDER => [
            \Raid\Core\Auth\Authentication\Login\SystemLogin\Managers\EmailLoginManager::class,
            \Raid\Core\Auth\Authentication\Login\SystemLogin\Managers\PhoneLoginManager::class,
            \Raid\Core\Auth\Authentication\Login\SystemLogin\Managers\UsernameLoginManager::class,
            \Raid\Core\Auth\Authentication\Login\SystemLogin\Managers\EmailOrPhoneLoginManager::class,
        ],
    ],
];
