<?php

namespace Raid\Core\Auth\Traits\Authentication;

trait WithSteps
{
    /**
     * Get authentication steps.
     */
    public function steps(): array
    {
        return [];
    }

    /**
     * Run authentication steps.
     */
    public function runSteps(array $steps): bool
    {
        if (empty($steps)) {
            return false;
        }

        foreach ($steps as $step) {
            app($step)->step($this);
        }

        return true;
    }
}
