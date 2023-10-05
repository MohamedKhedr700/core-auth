<?php

namespace Raid\Core\Auth\Authentication\Login\SystemLogin\Managers;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;
use Raid\Core\Auth\Models\Authentication\Enum\LoginManager as LoginManagerEnum;

class EmailOrPhoneLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = LoginManagerEnum::EMAIL_OR_PHONE;

    /**
     * {@inheritDoc}
     */
    public function getColumn(object $accountable, array $credentials): string
    {
        return filter_var($this->getCredentialValue($credentials), FILTER_VALIDATE_EMAIL) ? LoginManagerEnum::EMAIL : LoginManagerEnum::PHONE;
    }
}
