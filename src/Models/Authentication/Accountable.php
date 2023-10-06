<?php

namespace Raid\Core\Auth\Models\Authentication;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Traits\Authentication\Accountable\Accountable as AccountableTrait;

abstract class Accountable implements AccountableInterface
{
    use AccountableTrait;
}
