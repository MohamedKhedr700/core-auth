<?php

namespace Raid\Core\Auth\Traits\Authentication\LoginProvider;

trait WithCredentials
{
    /**
     * Login credentials.
     */
    protected array $credentials = [];

    /**
     * Set login credentials.
     */
    public function setCredentials(array $credentials): void
    {
        $this->credentials = $credentials;
    }

    /**
     * Get login credentials.
     */
    public function credentials(): array
    {
        return $this->credentials;
    }
}
