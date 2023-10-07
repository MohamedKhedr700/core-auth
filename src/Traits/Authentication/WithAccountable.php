<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;

trait WithAccountable
{
    /**
     * Accountable instance.
     */
    protected AccountableInterface $accountable;

    /**
     * Set login accountable.
     */
    public function setAccountable(AccountableInterface $accountable): void
    {
        $this->accountable = $accountable;
    }

    /**
     * Get login accountable.
     */
    public function accountable(): AccountableInterface
    {
        return $this->accountable;
    }
}