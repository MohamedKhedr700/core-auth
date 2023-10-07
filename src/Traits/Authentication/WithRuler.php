<?php

namespace Raid\Core\Auth\Traits\Authentication;

trait WithRuler
{
    /**
     * {@inheritdoc}
     */
    public function rulers(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function checkRulers(array $rulers): bool
    {
        foreach ($rulers as $ruler) {
            if (app($ruler)->rule($this)) {
                continue;
            }

            return false;
        }

        return true;
    }
}
