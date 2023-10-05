<?php

namespace Raid\Core\Auth\Authentication\Login\SystemLogin\Managers;

use Illuminate\Support\Str;
use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;
use Raid\Core\Auth\Models\Authentication\Enum\LoginManager as LoginManagerEnum;

class EmailOrPhoneLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = LoginManagerEnum::EMAIL_OR_PHONE;

    /**
     * {@inheritDoc}
     */
    public function fetchUser(object $accountable, array $credentials): ?AccountInterface
    {
        $value = $credentials[static::manager()];

        $column = filter_var($value, FILTER_VALIDATE_EMAIL) ? LoginManagerEnum::EMAIL : LoginManagerEnum::PHONE;

        $column = Str::snake($column);

        return $accountable->where($column, $value)->first();
    }
}
