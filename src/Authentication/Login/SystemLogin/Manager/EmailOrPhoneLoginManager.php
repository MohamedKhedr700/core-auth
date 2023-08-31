<?php

namespace Raid\Core\AuthAuthentication\Login\SystemLogin\Manager;

use Raid\Core\AuthAuthentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\AuthAuthentication\Login\LoginManager;
use Raid\Core\AuthModels\Authentication\Enum\LoginColumn;

class EmailOrPhoneLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const COLUMN = LoginColumn::EMAIL_OR_PHONE;
}
