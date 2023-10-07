<?php

namespace Raid\Core\Auth\Authentication\Contracts;

use Raid\Core\Auth\Authentication\Contracts\Concerns\WithAccountableInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithAccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithAuthenticationInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithCredentialsInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithRulerInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithTokenInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

interface AuthManagerInterface extends WithAccountableInterface, WithAccountInterface, WithAuthenticationInterface, WithCredentialsInterface, WithRulerInterface, WithTokenInterface, WithWorkerInterface
{
    /**
     * Get a login manager.
     */
    public static function manager(): string;

    /**
     * Attempt to authenticate an accountable in statically.
     */
    public static function auth(string $accountable, array $credentials): AuthManagerInterface;

    /**
     * Attempt to authenticate an account in statically.
     */
    public static function authAccount(string $accountable, AccountInterface $account): AuthManagerInterface;

    /**
     * Authenticate an accountable.
     */
    public function authenticate(AccountableInterface $accountable, array $credentials): AuthManagerInterface;

    /**
     * Authenticate an account.
     */
    public function authenticateAccount(AccountableInterface $accountable, AccountInterface $account): AuthManagerInterface;
}
