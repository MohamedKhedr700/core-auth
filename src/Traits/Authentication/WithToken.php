<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Laravel\Sanctum\NewAccessToken;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

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
     * {@inheritdoc}
     */
    public function createToken(AccountInterface $account): void
    {
        $this->setToken($account->createAccountToken());

        $this->authenticated = true;
    }

    /**
     * Get token response.
     */
    public function tokenResponse(): array
    {
        $account = $this->account();

        return $account->getTokenResponse($account->accountType(), $this->stringToken());
    }

    /**
     * Get user string token if presentable.
     */
    public function stringToken(): string
    {
        return (string) $this->token('plainTextToken');
    }
}
