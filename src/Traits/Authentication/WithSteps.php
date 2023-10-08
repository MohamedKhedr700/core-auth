<?php

namespace Raid\Core\Auth\Traits\Authentication;

trait WithSteps
{
    /**
     * {@inheritdoc}
     */
    public function steps(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
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
