<?php

namespace Raid\Core\Auth\Authentication\Managers;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\AuthManager;
use Raid\Core\Auth\Authentication\Rulers\MatchingPasswordRule;
use Raid\Core\Auth\Models\Authentication\Enum\Manager;

class SystemAuthManager extends AuthManager implements AuthManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = Manager::SYSTEM;

    /**
     * {@inheritdoc}
     */
    public function rulers(): array
    {
        return [
            MatchingPasswordRule::class,
        ];
    }
}
