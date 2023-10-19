<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

if (! function_exists('account')) {
    /**
     * Get an authenticated account.
     */
    function account(): ?AccountInterface
    {
        return auth()->check() ? auth()->user() : null;
    }
}

if (! function_exists('authenticate_account')) {
    /**
     * Authenticate account.
     */
    function authenticate_account(Authenticatable $authenticatable): AccountInterface
    {
        Auth::setUser($authenticatable);

        return account();
    }
}


if (! function_exists('auth_check')) {
    /**
     * Check if the given guard is authenticated.
     */
    function auth_check(string $guard = null): bool
    {
        return $guard ? Auth::guard($guard)->check() : Auth::check();
    }
}

if (! function_exists('get_account_avatar')) {
    /**
     * Get account avatar based on his name from https://ui-avatars.com/.
     */
    function get_account_avatar(string $name): string
    {
        return 'https://ui-avatars.com/api/?name='.str_replace(' ', '-', $name);
    }
}