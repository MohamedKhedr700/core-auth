<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Laravel\Sanctum\NewAccessToken;

trait Tokenable
{
    /**
     * Generate access token and response with the plain text token and user type.
     */
    public function generateToken(array $permissions = []): array
    {
        $accountType = $this->accountType();

        $accessToken = $this->createAccountToken($permissions)->plainTextToken;

        return $this->getTokenResponse($accountType, $accessToken);
    }

    /**
     * Create account token.
     */
    public function createAccountToken(array $permissions = []): NewAccessToken
    {
        $tokenName = $this->attribute('email') ?? $this->attribute('phone') ?? $this->attribute('deviceId');

        return $this->createToken($tokenName.'-'.$this->accountType(), $permissions);
    }

    /**
     * Get token response.
     */
    public function getTokenResponse(string $accountType, string $accessToken): array
    {
        return [
            'accountType' => $accountType,
            'accessToken' => $accessToken,
        ];
    }
}
