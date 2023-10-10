<?php

namespace Raid\Core\Auth\Commands;

use Raid\Core\Command\Commands\CreateCommand;

class CreateAuthAuthenticatorCommand extends CreateCommand
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'core:make-auth-authenticator {classname}';

    /**
     * The console command description.
     */
    protected $description = 'Make an auth authenticator class';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->createCommand();
    }

    /**
     * Return the stub file path.
     */
    public function getStubPath(): string
    {
        return __DIR__.'/../../resources/stubs/auth-authenticator.stub';
    }

    /**
     * Map the stub variables present in stub to its value.
     */
    public function getStubVariables(): array
    {
        return [
            'NAMESPACE' => 'App\\Http\\Authentication\\Authenticators',
            'CLASS_NAME' => $this->getClassName(),
        ];
    }

    /**
     * Get the full path of generated class.
     */
    public function getSourceFilePath(): string
    {
        return app_path('Http/Authentication/Authenticators/'.$this->getClassName()).'.php';
    }
}
