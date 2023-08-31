<?php

namespace Raid\Core\Auth\Traits\Authentication\LoginProvider;

trait WithAccountable
{
    /**
     * Accountable instance.
     */
    protected object $accountable;

    /**
     * Set login accountable.
     */
    public function setAccountable(object $accountable): void
    {
        $this->accountable = $accountable;
    }

    /**
     * Get login accountable.
     */
    public function accountable(): object
    {
        return $this->accountable;
    }
}
