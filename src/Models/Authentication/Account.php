<?php

namespace Raid\Core\AuthModels\Authentication;

use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Raid\Core\Auth\Traits\Authentication\Accountable;
use Raid\Core\AuthAuthentication\Contracts\AccountInterface;
use Raid\Core\Auth\Traits\Authentication\Authenticatable as AuthenticatableResolver;
use Raid\Core\Auth\Traits\Authentication\Deviceable;
use Raid\Core\Auth\Traits\Authentication\Loginable;
use Raid\Core\Auth\Traits\Authentication\Relationable;
use Raid\Core\Auth\Traits\Authentication\Tokenable;
use Raid\Core\Auth\Traits\Authentication\WithPassword;
use Raid\Core\Model\Models\Contracts\ModelInterface;
use Raid\Core\Model\Models\Model;

abstract class Account extends Model implements ModelInterface, AccountInterface, Authenticatable
{
    use Accountable,
        AuthenticatableResolver,
        Deviceable,
        HasApiTokens,
        Loginable,
        Relationable,
        Tokenable,
        WithPassword;

    /**
     * {@inheritdoc}
     */
    protected string $filter;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [];

    /**
     * {@inheritdoc}
     */
    protected $appends = [];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Account fillable attributes.
     */
    protected array $accountFillable = [
        'account_type', 'first_name', 'last_name', 'email',
        'country_code', 'phone', 'full_phone', 'password',
        'devices', 'is_disabled', 'is_verified', 'is_active',
        'last_login_at', 'last_login_ip',
    ];

    /**
     * {@inheritdoc}
     */
    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Account $account) {
            static::fillAccountType($account);
        });
    }

    /**
     * Fill account type attribute.
     */
    public static function fillAccountType(Account $account): void
    {
        $account->fillAttribute('account_type', $account->accountType());
    }

    /**
     * Get the fillable attributes for the model.
     */
    public function getFillable(): array
    {
        return array_merge(parent::getFillable(), $this->accountFillable);
    }
}
