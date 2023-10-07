<?php

namespace Raid\Core\Auth\Traits\Authentication;

trait WithSteps
{
    /**
     * Get all authentication steps.
     */
    public function steps(): array
    {
        return [];
    }

    /**
     * Run all authentication steps.
     */
    public function runSteps(array $steps): bool
    {
        if (empty($steps)) {
            return false;
        }

        foreach ($steps as $step) {
            $step->step();
        }

        return true;
    }
}
