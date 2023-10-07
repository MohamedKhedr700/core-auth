<?php

namespace Raid\Core\Auth\Authentication\Workers;

use Raid\Core\Auth\Authentication\Contracts\LoginWorkerInterface;
use Raid\Core\Auth\Authentication\LoginWorker;
use Raid\Core\Auth\Models\Authentication\Enum\Worker;

class UsernameLoginWorker extends LoginWorker implements LoginWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = Worker::USERNAME;
}
