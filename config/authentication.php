<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Authentication Manager
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication manager that will be used.
    | The provider is used to determine which login manager should be used
    | while authenticating accounts using the authentication facade.
    |
    */

    'default_auth_manager' => \Raid\Core\Auth\Authentication\Managers\SystemAuthManager::class,

    /*
    |--------------------------------------------------------------------------
    | Authenticators
    |--------------------------------------------------------------------------
    |
    | This option controls the authenticators that will be used in the application.
    |
    */

    'authenticators' => [],

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
    | Here you can define the authentication manager workers that will be used in the application.
    |
    */

    'manager_workers' => [
        \Raid\Core\Auth\Authentication\Managers\DeviceAuthManager::MANAGER => [
            \Raid\Core\Auth\Authentication\Workers\DeviceIdAuthWorker::class,
        ],
        \Raid\Core\Auth\Authentication\Managers\SystemAuthManager::MANAGER => [
            \Raid\Core\Auth\Authentication\Workers\EmailAuthWorker::class,
            \Raid\Core\Auth\Authentication\Workers\PhoneAuthWorker::class,
            \Raid\Core\Auth\Authentication\Workers\UsernameAuthWorker::class,
            \Raid\Core\Auth\Authentication\Workers\EmailOrPhoneAuthWorker::class,
        ],
    ],
];
