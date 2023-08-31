<?php

namespace Raid\Core\Auth\Traits\Authentication;

trait Accountable
{
    /**
     * @const string
     */
    public const ACCOUNT_TYPE = '';

    /**
     * {@inheritdoc}
     */
    public static function accountType(): string
    {
        return static::ACCOUNT_TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function accountId(): string
    {
        return $this->getId();
    }

    /**
     * Define shared attributes from an account model with an account type.
     */
    public function sharedWithAccountType(...$sharedAttributes): array
    {
        if (empty($sharedAttributes)) {
            $sharedAttributes = static::sharedAttributes();
        }

        $sharedAttributes = array_merge($sharedAttributes, ['account_type']);

        return $this->shared(...$sharedAttributes);
    }

    /**
     * Check if the current user is one of the given types.
     */
    public function typeIn(array $types): bool
    {
        return in_array($this->accountType(), $types);
    }

    /**
     * Check if a current user account type is matching the given type.
     */
    public function typeIs(string $type): bool
    {
        return $this->accountType() === $type;
    }
}
