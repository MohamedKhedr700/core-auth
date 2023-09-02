<?php

use Raid\Core\Auth\Models\Authentication\Enum\LoginType;

return [

    /*
    |--------------------------------------------------------------------------
    | Login Managers
    |--------------------------------------------------------------------------
    |
    | Here you can define the login managers that will be used in the application.
    |
    */

    'login_managers' => [
        LoginType::DEVICE => [
            \Raid\Core\Auth\Authentication\Login\DeviceLogin\Manager\DeviceIdLoginManager::class,
        ],
        LoginType::SYSTEM => [
            \Raid\Core\Auth\Authentication\Login\SystemLogin\Manager\EmailLoginManager::class,
            \Raid\Core\Auth\Authentication\Login\SystemLogin\Manager\PhoneLoginManager::class,
            \Raid\Core\Auth\Authentication\Login\SystemLogin\Manager\EmailOrPhoneLoginManager::class,
        ],
    ],

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
];
