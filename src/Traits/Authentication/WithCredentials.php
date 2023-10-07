<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Illuminate\Support\Arr;

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
    public function credentials(string $key = null, mixed $default = null): mixed
    {
        return $key ? Arr::get($this->credentials, $key, $default) : $this->credentials;
    }
}
