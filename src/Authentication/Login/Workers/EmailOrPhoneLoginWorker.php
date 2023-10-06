<?php

namespace Raid\Core\Auth\Authentication\Login\Workers;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginWorkerInterface;
use Raid\Core\Auth\Authentication\Login\LoginWorker;
use Raid\Core\Auth\Models\Authentication\Enum\LoginManager as LoginManagerEnum;
use Raid\Core\Auth\Models\Authentication\Enum\Worker;

class EmailOrPhoneLoginWorker extends LoginWorker implements LoginWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = Worker::EMAIL_OR_PHONE;

    /**
     * {@inheritDoc}
     */
    public function getColumn(object $accountable, array $credentials): string
    {
        return filter_var($this->getCredentialValue($credentials), FILTER_VALIDATE_EMAIL) ? LoginManagerEnum::EMAIL : LoginManagerEnum::PHONE;
    }
}