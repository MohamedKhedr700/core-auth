<?php

namespace Raid\Core\Auth\Traits\Authentication;

trait WithRules
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function runRules(array $rules): bool
    {
        foreach ($rules as $rule) {
            if (app($rule)->rule($this)) {
                continue;
            }

            return false;
        }

        return true;
    }
}
