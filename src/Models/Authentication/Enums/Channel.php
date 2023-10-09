<?php

namespace Raid\Core\Auth\Models\Authentication\Enums;

use Raid\Core\Enum\Enums\Enum;

class Channel extends Enum
{
    public const DEVICE = 'device';

    public const SYSTEM = 'system';

    public const THIRD_PARTY = 'thirdParty';
}
