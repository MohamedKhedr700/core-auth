<?php

namespace Raid\Core\Auth\Authentication\Login;

use Raid\Core\Auth\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Traits\Authentication\Login\WithAccount;
use Raid\Core\Auth\Traits\Authentication\Login\WithAccountable;
use Raid\Core\Auth\Traits\Authentication\Login\WithAuthentication;
use Raid\Core\Auth\Traits\Authentication\Login\WithCredentials;
use Raid\Core\Auth\Traits\Authentication\Login\WithToken;
use Raid\Core\Auth\Traits\Authentication\Login\WithWorker;
use Raid\Core\Model\Traits\Error\WithErrors;

abstract class LoginManager implements LoginManagerInterface
{
    use WithAccount;
    use WithAccountable;
    use WithAuthentication;
    use WithCredentials;
    use WithErrors;
    use WithToken;
    use WithWorker;

    /**
     * Login manager.
     */
    public const MANAGER = '';

    /**
     * {@inheritdoc}
     */
    public function login(AccountableInterface $accountable, array $credentials): static
    {
        $this->setAccountable($accountable);

        $this->setCredentials($credentials);

        $account = $this->findWorkerAccount($accountable, $credentials);

        if ($this->errors()->any()) {
            return $this;
        }

        if (method_exists($this, 'steps')) {
            return $this;
        }

        $rulers = $this->rulers();

        if (! empty($rulers) && ! $this->checkRulers($rulers)) {
            return $this;
        }

        $this->authenticate($account);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rulers(): array
    {
        return [
            LoginRuler::class,
        ];
    }

    /**
     * Check login rulers.
     */
    public function checkRulers(array $rulers): bool
    {
        foreach ($rulers as $ruler) {
            if ($ruler->rule($this)) {
                continue;
            }

            return false;
        }

        return true;
    }
}
