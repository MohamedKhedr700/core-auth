<?php

namespace Raid\Core\Auth\Models\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Traits\Model\Authenticatable;

class Authenticated implements AuthenticatableInterface
{
    use Authenticatable;
}