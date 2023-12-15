<?php

namespace Raid\Core\Auth\Traits\Model;

trait WithAuthIdentifier
{
    /**
     * {@inheritDoc}
     */
    public function getAuthIdentifierName()
    {
        return $this->getKeyName();
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthIdentifier()
    {
        return $this->attribute($this->getAuthIdentifierName());
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthPassword()
    {
        return $this->attribute('password');
    }

    /**
     * {@inheritDoc}
     */
    public function getRememberToken()
    {
        return $this->attribute('remember_token');
    }

    /**
     * {@inheritDoc}
     */
    public function setRememberToken($value)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getRememberTokenName()
    {
        return $this->attribute('remember_token_name');
    }
}
