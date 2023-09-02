<?php

namespace Raid\Core\Auth\Authentication\Login\SystemLogin\Manager;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;
use Raid\Core\Auth\Models\Authentication\Enum\LoginColumn;

class EmailLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const COLUMN = LoginColumn::EMAIL;
}
