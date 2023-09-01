<?php

namespace Raid\Core\AuthAuthentication\Login;

use Illuminate\Support\Str;
use Raid\Core\AuthAuthentication\Contracts\AccountInterface;
use Raid\Core\AuthAuthentication\Contracts\Login\LoginManagerInterface;

abstract class LoginManager implements LoginManagerInterface
{
    /**
     * @const string
     */
    public const COLUMN = '';

    /**
     * {@inheritDoc}
     */
    public static function column(): string
    {
        return static::COLUMN;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchUser(object $accountable, array $credentials): ?AccountInterface
    {
        //        $filters = [Str::snake(static::column()) => $credentials[static::column()]];

        $column = Str::snake(static::column());
        $value = $credentials[static::column()];

        return $accountable->where($column, $value)->first();
    }
}
