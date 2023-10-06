<?php

namespace Raid\Core\Auth\Authentication\Login\Workers;

use Raid\Core\Auth\Authentication\Login\Contracts\LoginWorkerInterface;
use Raid\Core\Auth\Authentication\Login\LoginWorker;
use Raid\Core\Auth\Models\Authentication\Enum\Worker;

class EmailLoginWorker extends LoginWorker implements LoginWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = Worker::EMAIL;
}
