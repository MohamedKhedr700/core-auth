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

    'managers' => [
        'managers' => [
            LoginType::DEVICE => [
                \Raid\Core\AuthAuthentication\Login\DeviceLogin\Manager\DeviceIdLoginManager::class,
            ],
            LoginType::SYSTEM => [
                \Raid\Core\AuthAuthentication\Login\SystemLogin\Manager\EmailLoginManager::class,
                \Raid\Core\AuthAuthentication\Login\SystemLogin\Manager\PhoneLoginManager::class,
                \Raid\Core\AuthAuthentication\Login\SystemLogin\Manager\EmailOrPhoneLoginManager::class,
            ],
        ],
    ],
];
