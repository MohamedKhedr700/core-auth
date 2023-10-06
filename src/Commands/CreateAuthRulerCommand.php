<?php

namespace Raid\Core\Auth\Commands;

use Raid\Core\Command\Commands\CreateCommand;

class CreateAuthRulerCommand extends CreateCommand
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'core:make-auth-ruler {classname}';

    /**
     * The console command description.
     */
    protected $description = 'Make an auth ruler class';

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
        return __DIR__.'/../../resources/stubs/auth-ruler.stub';
    }

    /**
     * Map the stub variables present in stub to its value.
     */
    public function getStubVariables(): array
    {
        return [
            'NAMESPACE' => 'App\\Http\\Authentication\\Rulers',
            'CLASS_NAME' => $this->getClassName(),
        ];
    }

    /**
     * Get the full path of generated class.
     */
    public function getSourceFilePath(): string
    {
        return app_path('Http/Authentication/Rulers/'.$this->getClassName()).'.php';
    }
}
