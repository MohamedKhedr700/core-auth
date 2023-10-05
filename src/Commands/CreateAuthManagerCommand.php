<?php

namespace Raid\Core\Auth\Commands;

use Raid\Core\Command\Commands\CreateCommand;

class CreateAuthManagerCommand extends CreateCommand
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'core:make-auth-manager {classname}';

    /**
     * The console command description.
     */
    protected $description = 'Make an auth manager class';

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
        return __DIR__.'/../../resources/stubs/auth-manager.stub';
    }

    /**
     * Map the stub variables present in stub to its value.
     */
    public function getStubVariables(): array
    {
        return [
            'NAMESPACE' => 'App\\Http\\Authentication\\Managers',
            'CLASS_NAME' => $this->getClassName(),
        ];
    }

    /**
     * Get the full path of generated class.
     */
    public function getSourceFilePath(): string
    {
        return app_path('Http/Authentication/Managers/'.$this->getClassName()).'.php';
    }
}
