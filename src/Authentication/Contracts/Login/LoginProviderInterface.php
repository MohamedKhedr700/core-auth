<?php

namespace Raid\Core\Auth\Authentication\Contracts\Login;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;

interface LoginProviderInterface
{
    /**
     * Get a login provider.
     */
    public static function provider(): string;

    /**
     * Attempt Log in statically.
     */
    public static function attempt(string $accountable, array $credentials): LoginProviderInterface;

    /**
     * Attempt Log in statically with an account.
     */
    public static function attemptAccount(string $accountable, AccountInterface $account): LoginProviderInterface;

    /**
     * Attempt Log in.
     */
    public function login(object $accountable, array $credentials): LoginProviderInterface;

    /**
     * Attempt Log in with an account.
     */
    public function loginAccount(object $accountable, AccountInterface $account): LoginProviderInterface;

    /**
     * Check login provider rules after find user.
     */
    public function checkLoginRules(AccountInterface $account, array $credentials = []): bool;

    /**
     * Authenticate account.
     */
    public function authenticateAccount(AccountInterface $account): void;

    /**
     * Check active user login based on a model.
     * Method `isLoginActive` found in a user model to control login check.
     * Base method in Accountable trait.
     */
    public function checkAccountAuthentication(AccountInterface $account): bool;
}
