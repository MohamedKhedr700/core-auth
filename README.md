# Core Auth Package

This package is responsible for handling all authentication models and channels in the system.

## Installation

``` bash
composer require raid/core-auth
```

## Configuration

``` bash
php artisan core:publish-auth
```

## Usage

``` php
class AuthController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request, SystemAuthChannel $authChannel): JsonResponse
    {
        $credentials = $request->only([
            'email', 'phone', 'username', 'password',
        ]);

        $authChannel = $authChannel->authenticate(new User(), $credentials);

        // or using static call
        $authChannel = SystemAuthChannel::auth(User::class, $credentials);

        // or using facade
        $authChannel = Authentication::authenticate(new User(), $credentials);

        return response()->json([
            'channel' => $authChannel->channel(),
            'token' => $authChannel->stringToken(),
            'errors' => $authChannel->errors()->toArray(),
            'resource' => $authChannel->account(),
        ]);
    }
}
```

# How to work this

The authentication process is divided into two parts.

The first part is the authenticatable class, and the second part is the auth channel.

The `Authenticatable` class is the class that will be authenticated,
and it must implement `AuthenticatableInterface` interface.

The `AuthChannel` class is the class that will handle the authentication process,
and it must implement `AuthChannelInterface` interface.

The `AuthChannel` uses the `Authenticatable` class to query the account using the given credentials.

The `Authenticatable` class must define `getAccount` method to query the account,
and return an instance of `AccountInterface` interface.

The `Authenticatable` class can be the same or different from the `AccountInterface` class,
but it must query the account and return an instance of `AccountInterface` interface if found.

Let's start with our `AccountInterface` class ex:`User` model,
we can use this command to create an account model.

``` bash
php artisan core:make-auth-model User
```
``` php
<?php

namespace App\Models;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Models\Authentication\Account;

class User extends Account implements AccountInterface
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [];
}
```

The `Model` class must implement `AccountInterface` interface.

The `Model` class must extend `Account` class.

Now the `User` model class is ready to use as an account model.

Let's configure our `Model` class to work as `Authenticatable` class also.

``` php
<?php

namespace App\Models;

use Raid\Core\Auth\Models\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Models\Authentication\Account;
use Raid\Core\Auth\Traits\Model\Authenticatable;

class User extends Account implements AccountInterface, AuthenticatableInterface
{
    use Authenticatable;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [];
}
```

### Auth Channels and Workers
#

Great, now we have to take a look at our authentication channels and workers in `config/authentication.php` file.

``` php
'channel_workers' => [
    // here we define our auth channels.
    SystemAuthChannel::CHANNEL => [
        // here we define our auth workers.
        EmailAuthWorker::class,
        PhoneAuthWorker::class,
        EmailOrPhoneAuthWorker::class,
    ],
],
```

The `channel_workers` array is responsible for defining the auth channels and their workers.
and we can add our custom channels and workers.

The `AuthChannel` is responsible for handling the authentication process.

Each auth channel has its own workers, and each auth worker has its own authentication name/worker.

When we call `AuthChannel` authenticate method,
it will call the matched auth worker with the given credentials.

We can add a custom auth worker to use it with the `SystemAuthChannel` channel or any other auth channel.

### Auth Workers
#

you can use this command to create a new auth worker.


``` bash
php artisan core:make-auth-worker UsernameAuthWorker
```

``` php
<?php

namespace App\Http\Authentication\Workers;

use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Authentication\AuthWorker;

class UsernameAuthWorker extends AuthWorker implements AuthWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = '';
}

```

The `AuthWorker` class must implement `AuthWorkerInterface` interface.

The `AuthWorker` class must extend `AuthWorker` class.

The `WORKER` constant is responsible for defining the auth worker name.

The `WORKER` constant is used to match the auth worker with the given credentials.

The `WORKER` constant is used to define the authenticatable query column,
to override using same key for credentials and query, define the `QUERY_COLUMN` constant.

``` php
<?php

namespace App\Http\Authentication\Workers;

use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Authentication\AuthWorker;

class UsernameAuthWorker extends AuthWorker implements AuthWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = 'username';
    
    /**
     * {@inheritdoc}
     */
    public const QUERY_COLUMN = 'user_name';
}

```

The `QUERY_COLUMN` constant is used to define the authenticatable query column.

We need to define the new auth worker in `config/authentication.php` file,
to skip using config file, we can use the `workers` method in the `AuthChannel` class to define its workers.

``` php
'manager_workers' => [
    // here we define our auth managers.
    SystemAuthChannel::CHANNEL => [
        // here we define our auth workers.
        EmailAuthWorker::class,
        PhoneAuthWorker::class,
        EmailOrPhoneAuthWorker::class,
        UsernameAuthWorker::class,
    ],
],
```

Now let's try our new auth worker.

``` php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Raid\Core\Auth\Authentication\Channels\SystemAuthChannel;

class AuthController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request, SystemAuthChannel $authChannel): JsonResponse
    {
        $credentials = $request->only([
            'username', 'password',
        ]);

        $authChannel = $authChannel->authenticate(new User(), $credentials);

        return response()->json([
            'channel' => $authChannel->channel(),
            'token' => $authChannel->stringToken(),
            'errors' => $authChannel->errors()->toArray(),
            'resource' => $authChannel->account(),
        ]);
    }
}
```

The `SystemAuthChannel` authenticate method accepts two parameters.

The first parameter is the authenticatable class instance.

The second parameter is the credentials array.

The `SystemAuthChannel` authenticate method returns the `AuthChannel` class instance.

The `AuthChannel` class instance uses the credentials array to match with auth worker.

The `AuthChannel` class instance used the matched worker to query the authenticatable class to find the matched account.

The `AuthChannel` class apply its own authentication rules after finding the account.

The `Authenticatable` class instance must work with query builder to find the account.

Under the hood,
the `AuthWorker` class calls `getAccount` method in the `Authenticatable` class instance.

The returned account must be an instance of `AccountInterface` interface.

After finding the account, and apply the `AuthChannel` rules,
you can apply authentication rules on the account itself using `isAuthenticated` method.

``` php
<?php

namespace App\Models;

use Raid\Core\Auth\Exceptions\Authentication\AuthenticationException;
use Raid\Core\Auth\Models\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Models\Authentication\Account;
use Raid\Core\Auth\Traits\Model\Authenticatable;

class User extends Account implements AccountInterface, AuthenticatableInterface
{
    use Authenticatable;
    
    /**
     * Check if an account is active to authenticated.
     * Throw Authentication exception if failed to authenticate.
     */
    public function isAuthenticated(): void
    {
        if ($this->isBanned()) {
            throw new AuthenticationException(__('User is banned.'));
        }
    }
    
        /**
     * Determine if user is banned.
     */
    public function isBanned(): bool
    {
        return $this->attribute('is_banned', false);
    }
}
```

The `isAuthenticated` method is responsible for checking if the account is authenticated or not.

The `isAuthenticated` method should throw an exception if the account is not authenticated.

The `AuthenticationException` will not be thrown in the system,
but the errors can be called with the `errors` method in the `AuthChannel` instance.

The `errors` method will return an `Raid\Core\Model\Errors\Errors` instance.

Remember, any other exception but `AuthenticationException` will be thrown in the system.

### Errors
#

You can work with the `errors` method as a `Illuminate\Support\MessageBag` instance,
and you can get your errors with different methods.

``` php
$authChannel = $authChannel->authenticate(new User(), $credentials);

$errorsAsArray = $authChannel->errors()->toArray();
$errorsAsJson = $authChannel->errors()->toJson();

$allErrors = $authChannel->errors()->all();

$errorsByKey = $authChannel->errors()->get('error');

$firstError = $authChannel->errors()->first();
$firstErrorByKey = $authChannel->errors()->first('error');

$lastError = $authChannel->errors()->last();
$lastErrorByKey = $authChannel->errors()->last('error');
```

The `errors` method returns an `Raid\Core\Model\Errors\Errors` class instance.

The `toArray` method returns an array of errors.

The `toJson` method returns a json string of errors.

The `all` method returns all errors as an array.

The `get` method returns an array of errors for the given key.

The `first` method returns the first error, or the first error for the given key.

The `last` method returns the last error, or the last error for the given key.

You can work with `errors` method again in the `AuthChannel` class.

### Auth Channels
#

You can create your own auth channel using this command.

``` bash
php artisan core:make-auth-channel OtpAuthChannel
```

``` php
<?php

namespace App\Http\Authentication\Channels;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\AuthChannel;

class OtpAuthChannel extends AuthChannel implements AuthChannelInterface
{
    /**
     * {@inheritdoc}
     */
    public const CHANNEL = '';
}
```

The `AuthChannel` class must implement `AuthChannelInterface` interface.

The `AuthChannel` class must extend `AuthChannel` class.

The `CHANNEL` constant is responsible for defining the authentication channel name.

The auth channel is the main class that handles the authentication process,
and it defines his own authentication `workers`, `rules` and `steps`.

``` php
<?php

namespace App\Http\Authentication\Channels;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\AuthChannel;

class OtpAuthChannel extends AuthChannel implements AuthChannelInterface
{
    /**
     * {@inheritdoc}
     */
    public const CHANNEL = 'otp';

    /**
     * Get authentication workers.
     */
    public function workers(): array
    {
        return [];
    }
    
    /**
     * Get authentication rules.
     */
    public function rules(): array
    {
        return [];
    }
    
    /**
     * Get authentication steps.
     */
    public function steps(): array
    {
        return [];
    }
}
```

The `workers` method is responsible for defining the `AuthChannel` authentication workers.

The `workers` method should return an array of authentication workers.

The `rules` method is responsible for defining the `AuthChannel` authentication rules.

The `rules` method should return an array of authentication rules.

The `steps` method is responsible for defining the `AuthChannel` authentication steps.

The `steps` method should return an array of authentication steps.

The `rules` run before the `steps`.

After running the `AuthChannel` authentication steps, the authentication process will be stopped,
and the `AuthChannel` will return the `AuthChannel` instance.

We can skip using authentication rules and steps by returning an empty array.

#### Auth Rules
#

you can use this command to create a new auth rule.

``` bash
php artisan core:make-auth-rule VerifiedPhoneAuthRule
```

``` php
<?php

namespace App\Http\Authentication\Rules;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthRuleInterface;

class VerifiedPhoneAuthRule implements AuthRuleInterface
{
    /**
     * Run an authentication ruler.
     */
    public function rule(AuthChannelInterface $authChannel): bool
    {
    }
}
```

The `AuthRule` class must implement `AuthRuleInterface` interface.

The `rule` method is responsible for running the authentication rule.

The `rule` method should return a boolean value.

The `rule` method should return `true` if the authentication rule passed,

The `rule` method should add `errors` to `AuthChannel` and return `false` if the authentication rule failed.

``` php
<?php

namespace App\Http\Authentication\Rules;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthRuleInterface;

class VerifiedPhoneAuthRule implements AuthRuleInterface
{
    /**
     * Run an authentication rule.
     */
    public function rule(AuthChannelInterface $authChannel): bool
    {
        if ($authChannel->account()->verifiedPhone()) {
            return true;
        }

        $authChannel->errors()->add('error', __('Phone number is not verified.'));

        return false;
    }
}
```

We need to define the new auth rule in `AuthChannel` class.

``` php
<?php

namespace App\Http\Authentication\Channels;

use App\Http\Authentication\Rules\VerifiedPhoneAuthRule;
use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\AuthChannel;

class OtpAuthChannel extends AuthChannel implements AuthChannelInterface
{
    /**
     * {@inheritdoc}
     */
    public const CHANNEL = 'otp';

    /**
     * Get authentication rules.
     */
    public function rules(): array
    {
        return [
            VerifiedPhoneAuthRule::class,
        ];
    }
}
```

The `AuthChannel` class instance will stop the authentication process if the authentication rule failed.

#### Auth Steps
#

you can use this command to create a new auth step.

``` bash
php artisan core:make-auth-step OtpAuthStep
```

``` php
<?php

namespace App\Http\Authentication\Steps;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthStepInterface;

class OtpAuthStep implements AuthStepInterface
{
    /**
     * Run an authentication step.
     */
    public function step(AuthChannelInterface $authChannel): void
    {
    }
}
```

The `AuthStep` class must implement `AuthStepInterface` interface.

The `step` method is responsible for running the authentication step.

The `step` method should add `errors` to `AuthChannel` if the authentication step failed.

``` php
<?php

namespace App\Http\Authentication\Steps;

use App\Services\OtpService;
use Exception;
use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthStepInterface;

class OtpAuthStep implements AuthStepInterface
{
    /**
     * Otp service.
     */
    protected OtpService $otpService;

    /**
     * Otp service.
     */
    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Run an authentication step.
     */
    public function step(AuthChannelInterface $authChannel): void
    {
        try {
        
            $this->otpService->send($authChannel->account());
            
        } catch (Exception $exception) {
            $authChannel->errors()->add('error', $exception->getMessage());
        }
    }
}
```

We need to define the new auth step in `AuthChannel` class.

``` php
<?php

namespace App\Http\Authentication\Channels;

use App\Http\Authentication\Steps\OtpAuthStep;
use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\AuthChannel;

class OtpAuthChannel extends AuthChannel implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const CHANNEL = 'otp';

    /**
     * Get authentication steps.
     */
    public function steps(): array
    {
        return [
            OtpAuthStep::class,
        ];
    }
}
```
We can run our authentication step.

The `AuthChannel` class instance will stop the authentication process after running all authentication steps.

### Authenticators
#

You can create your own authenticator using this command.

``` bash
php artisan core:make-auth-authenticator UserAuthenticator
```

``` php
<?php

namespace App\Http\Authentication\Authenticators;

use Raid\Core\Auth\Authentication\Contracts\AuthenticatorInterface;
use Raid\Core\Auth\Authentication\Authenticator;

class UserAuthenticator extends Authenticator implements AuthenticatorInterface
{
    /**
     * {@inheritdoc}
     */
    public const AUTHENTICATOR = '';

    /**
     * {@inheritdoc}
     */
    public const AUTHENTICATABLE = '';

    /**
     * {@inheritdoc}
     */
    public const CHANNELS = [];
```

The `Authenticator` class must implement `AuthenticatorInterface` interface.

The `Authenticator` class must extend `Authenticator` class.

The `AUTHENTICATOR` constant is responsible for defining the authenticator name.

The `AUTHENTICATABLE` constant is responsible for defining the authenticatable class name.

The `CHANNELS` constant is responsible for defining the authenticator channels.

The `CHANNELS` constant should return an array of authenticator channels.

``` php
<?php

namespace App\Http\Authentication\Authenticators;

use App\Http\Authentication\Channels\OtpAuthChannel;
use App\Models\User;
use Raid\Core\Auth\Authentication\Channels\SystemAuthChannel;
use Raid\Core\Auth\Authentication\Contracts\AuthenticatorInterface;
use Raid\Core\Auth\Authentication\Authenticator;

class UserAuthenticator extends Authenticator implements AuthenticatorInterface
{
    /**
     * {@inheritdoc}
     */
    public const AUTHENTICATOR = 'user';

    /**
     * {@inheritdoc}
     */
    public const AUTHENTICATABLE = User::class;

    /**
     * {@inheritdoc}
     */
    public const CHANNELS = [
        OtpAuthChannel::class,
        SystemAuthChannel::class,
    ];
}
```

The `Authenticator` class instance is responsible for handling the authentication with different channels.

We can define our authenticator with two ways:

First in `config/authentication.php` file.

``` php
'authenticators' => [
    User::class => UserAuthenticator::class,
],
```

or define `getAuthenticator` method in the `Authenticatable` class.

``` php
<?php

namespace App\Models;

use Raid\Core\Auth\Models\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Models\Authentication\Account;
use Raid\Core\Auth\Traits\Model\Authenticatable;
use App\Http\Authentication\Authenticators\UserAuthenticator;

class User extends Account implements AccountInterface, AuthenticatableInterface
{
    use Authenticatable;

    /**
     * Get authenticator class name.
     */
    public function getAuthenticator(): string
    {
        return UserAuthenticator::class;
    }
}

```

Now let's try our new authenticator.

``` php
namespace App\Http\Controllers;

use App\Http\Authentication\Authenticators\UserAuthenticator;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->only([
            'username', 'password',
        ]);

        $authManager = UserAuthenticator::attempt($credentials, 'otp');
        
        // or use authenticatable static call
        $authManager = User::attempt($credentials, 'otp');

        return response()->json([
            'channel' => $authChannel->channel(),
            'token' => $authChannel->stringToken(),
            'errors' => $authChannel->errors()->toArray(),
            'resource' => $authChannel->account(),
        ]);
    }
}
```

The `Authenticator` class instance is responsible for finding the matched authenticatable channel.

You can skip passing the channel name to use the default channel.

### Authentication Facade
#

You can define a default authentication channel,
and use the `Raid\Core\Auth\Facades\Authentication` facade to process the authentication.

Define the default authentication channel in `config/authentication.php` file.

``` php 
'default_channel' => \App\Http\Authentication\Channels\OtpAuthChannel::class,
```

``` php
namespace App\Http\Controllers;

use Raid\Core\Auth\Facades\Authentication;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->only([
            'username', 'password',
        ]);

        $authChannel = Authentication::authenticate(new User(), $credentials);

        return response()->json([
            'channel' => $authChannel->channel(),
            'token' => $authChannel->stringToken(),
            'errors' => $authChannel->errors()->toArray(),
            'resource' => $authChannel->account(),
        ]);
    }
}
```

The `Authentication` facade is responsible for handling the authentication process.

The `Authentication` facade uses the `default_channel` from the `config/authentication.php` file.

<br>

And that's it.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- **[Mohamed Khedr](https://github.com/MohamedKhedr700)**

## Security

If you discover any security-related issues, please email
instead of using the issue tracker.

## About Raid

Raid is a PHP framework created by **[Mohamed Khedr](https://github.com/MohamedKhedr700)**,
and it is maintained by **[Mohamed Khedr](https://github.com/MohamedKhedr700)**.

## Support Raid

Raid is an MIT-licensed open-source project. It's an independent project with its ongoing development made possible.

