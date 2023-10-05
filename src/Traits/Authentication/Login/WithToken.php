<?php

namespace Raid\Core\Auth\Traits\Authentication\Login;

use Laravel\Sanctum\NewAccessToken;

trait WithToken
{
    /**
     * Account token.
     */
    protected ?NewAccessToken $token = null;

    /**
     * Set user token.
     */
    public function setToken(NewAccessToken $token): void
    {
        $this->token = $token;
    }

    /**
     * Get user token.
     */
    public function token(string $key = null, mixed $default = null): mixed
    {
        return $key ? ($this->token->{$key} ?? $default) : $this->token;
    }

    /**
     * Get user string token if presentable.
     */
    public function stringToken(): string
    {
        return (string) $this->token('plainTextToken');
    }

    /**
     * Get token response.
     */
    public function tokenResponse(): array
    {
        $account = $this->account();

        return $account->getTokenResponse($account->accountType(), $this->stringToken());
    }
}
