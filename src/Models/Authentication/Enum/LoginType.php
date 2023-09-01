<?php

namespace Raid\Core\AuthModels\Authentication\Enum;

use Raid\Core\Enum\Models\Enum;

class LoginType extends Enum
{
    public const DEVICE = 'device';

    public const SYSTEM = 'system';

    public const THIRD_PARTY = 'thirdParty';
}
