<?php

namespace Raid\Core\Auth\Authentication\Workers;

use Raid\Core\Auth\Authentication\AuthWorker;
use Raid\Core\Auth\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Enums\Worker;

class EmailOrPhoneAuthWorker extends AuthWorker implements AuthWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = Worker::EMAIL_OR_PHONE;

    /**
     * {@inheritDoc}
     */
    public function getQueryColumn(AuthenticatableInterface $authenticatable, array $credentials): string
    {
        return filter_var($this->getWorkerValue($credentials), FILTER_VALIDATE_EMAIL) ? Worker::EMAIL : Worker::PHONE;
    }
}
