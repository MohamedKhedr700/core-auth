<?php

namespace Raid\Core\AuthModels\Authentication\Enum;

use Raid\Core\AuthEnum\Traits\Enum\ConstEnum;

class LoginType
{
    use ConstEnum;

    public const DEVICE = 'device';

    public const SYSTEM = 'system';

    public const THIRD_PARTY = 'thirdParty';
}
