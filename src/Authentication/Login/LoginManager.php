<?php

namespace Raid\Core\Auth\Authentication\Login;

use Illuminate\Support\Str;
use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;

abstract class LoginManager implements LoginManagerInterface
{
    /**
     * Login manager.
     */
    public const MANAGER = '';

    /**
     * {@inheritDoc}
     */
    public static function manager(): string
    {
        return static::MANAGER;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchUser(object $accountable, array $credentials): ?AccountInterface
    {
        $column = Str::snake(static::manager());

        $value = $credentials[static::manager()];

        return $accountable->where($column, $value)->first();
    }
}
