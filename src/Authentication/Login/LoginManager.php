<?php

namespace Raid\Core\Auth\Authentication\Login;

use Illuminate\Support\Str;
use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;

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
