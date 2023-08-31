<?php

namespace Raid\Core\AuthModels\Authentication\Enum;

use Raid\Core\AuthEnum\Traits\Enum\ConstEnum;

class LoginColumn
{
    use ConstEnum;

    public const DEVICE_ID = 'deviceId';

    public const EMAIL = 'email';

    public const PHONE = 'phone';

    public const EMAIL_OR_PHONE = 'emailOrPhone';
}
