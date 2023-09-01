<?php

namespace Raid\Core\Auth\Traits\Authentication\Login;

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
