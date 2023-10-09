<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthenticatableInterface;

trait WithAuthenticatable
{
    /**
     * Authenticatable instance.
     */
    protected AuthenticatableInterface $authenticatable;

    /**
     * Set authenticatable.
     */
    public function setAuthenticatable(AuthenticatableInterface $authenticatable): void
    {
        $this->authenticatable = $authenticatable;
    }

    /**
     * Get authenticatable.
     */
    public function authenticatable(): AuthenticatableInterface
    {
        return $this->authenticatable;
    }
}
