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
     * Attempt Log in statically.
     */
    public static function attempt(string $accountable, array $credentials): static;

    /**
     * Attempt Log in statically with an account.
     */
    public static function attemptAccount(string $accountable, AccountInterface $account): static;

    /**
     * Attempt Log in.
     */
    public function login(AccountableInterface $accountable, array $credentials): static;

    /**
     * Attempt Log in with an account.
     */
    public function loginAccount(AccountableInterface $accountable, AccountInterface $account): static;
}
