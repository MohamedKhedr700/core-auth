<?php

namespace Raid\Core\Auth\Models\Authentication\Enum;

use Raid\Core\Enum\Enums\Enum;

class LoginProvider extends Enum
{
    public const DEVICE = 'device';

    public const SYSTEM = 'system';

    public const THIRD_PARTY = 'thirdParty';
}
