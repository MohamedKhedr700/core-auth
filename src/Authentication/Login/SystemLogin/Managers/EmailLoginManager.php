<?php

namespace Raid\Core\Auth\Authentication\Login\SystemLogin\Managers;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;
use Raid\Core\Auth\Models\Authentication\Enum\LoginManager as LoginManagerEnum;

class EmailLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = LoginManagerEnum::EMAIL;
}
