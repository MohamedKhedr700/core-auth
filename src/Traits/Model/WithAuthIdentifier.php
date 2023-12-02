<?php

namespace Raid\Core\Auth\Traits\Model;

trait WithAuthIdentifier
{
    /**
     * {@inheritDoc}
     */
    public function getAuthIdentifierName()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthIdentifier()
    {
        return $this->attribute($this->getKeyName());
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthPassword()
    {
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
