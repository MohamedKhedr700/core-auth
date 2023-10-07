<?php

namespace Raid\Core\Auth\Authentication\Workers;

use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Authentication\AuthWorker;
use Raid\Core\Auth\Models\Authentication\Enum\Worker;

class EmailAuthWorker extends AuthWorker implements AuthWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = Worker::EMAIL;
}
