<?php

namespace Raid\Core\AuthAuthentication\Login;

use Illuminate\Support\Str;
use Raid\Core\AuthAuthentication\Contracts\AccountInterface;
use Raid\Core\AuthAuthentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\AuthRepositories\Contracts\RepositoryInterface;

abstract class LoginManager implements LoginManagerInterface
{
    /**
     * @const string
     */
    public const COLUMN = '';

    /**
     * {@inheritDoc}
     */
    public static function getColumn(): string
    {
        return static::COLUMN;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchUser(object $accountable, array $credentials): ?AccountInterface
    {
        $filters = [Str::snake(static::getColumn()) => $credentials[static::getColumn()]];

        return $accountable->findBy($filters);
    }
}
