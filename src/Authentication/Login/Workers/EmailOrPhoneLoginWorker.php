<?php

namespace Raid\Core\Auth\Authentication\Login\Workers;

use Raid\Core\Auth\Authentication\Login\Contracts\LoginWorkerInterface;
use Raid\Core\Auth\Authentication\Login\LoginWorker;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
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
    public function getQueryColumn(AccountableInterface $accountable, array $credentials): string
    {
        return filter_var($this->getWorkerValue($credentials), FILTER_VALIDATE_EMAIL) ? Worker::EMAIL : Worker::PHONE;
    }
}
