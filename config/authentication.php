<?php

use Raid\Core\AuthModels\Authentication\Enum\LoginType;

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
            \Raid\Core\AuthAuthentication\Login\DeviceLogin\Manager\DeviceIdLoginManager::class,
        ],
        LoginType::SYSTEM => [
            \Raid\Core\AuthAuthentication\Login\SystemLogin\Manager\EmailLoginManager::class,
            \Raid\Core\AuthAuthentication\Login\SystemLogin\Manager\PhoneLoginManager::class,
            \Raid\Core\AuthAuthentication\Login\SystemLogin\Manager\EmailOrPhoneLoginManager::class,
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

    'access_token_model' => \Raid\Core\AuthModels\AccessToken\AccessToken::class,
];
