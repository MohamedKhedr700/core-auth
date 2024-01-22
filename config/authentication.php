<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Authentication Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication channel that will be used.
    | The value is used to determine which authentication channel should be used
    | while authenticating accounts using the authentication facade.
    |
    */

    'default_channel' => \Raid\Core\Auth\Authentication\Channels\SystemAuthChannel::class,

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
    | Channel Managers
    |--------------------------------------------------------------------------
    |
    | Here you can define the authentication channel workers that will be used in the application.
    |
    */

    'channel_workers' => [
        \Raid\Core\Auth\Authentication\Channels\DeviceAuthChannel::CHANNEL => [
            \Raid\Core\Auth\Authentication\Workers\DeviceIdAuthWorker::class,
        ],
        \Raid\Core\Auth\Authentication\Channels\SystemAuthChannel::CHANNEL => [
            \Raid\Core\Auth\Authentication\Workers\EmailAuthWorker::class,
            \Raid\Core\Auth\Authentication\Workers\PhoneAuthWorker::class,
            \Raid\Core\Auth\Authentication\Workers\UsernameAuthWorker::class,
            \Raid\Core\Auth\Authentication\Workers\EmailOrPhoneAuthWorker::class,
        ],
    ],
];
