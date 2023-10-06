<?php

namespace Raid\Core\Auth\Authentication\Login\Workers;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginWorkerInterface;
use Raid\Core\Auth\Authentication\Login\LoginWorker;
use Raid\Core\Auth\Models\Authentication\Enum\Worker;

class PhoneLoginWorker extends LoginWorker implements LoginWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = Worker::PHONE;
}