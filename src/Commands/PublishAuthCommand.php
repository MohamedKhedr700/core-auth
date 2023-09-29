<?php

namespace Raid\Core\Auth\Commands;

use Raid\Core\Command\Commands\PublishCommand;

class PublishAuthCommand extends PublishCommand
{
    /**
     * The console command name.
     */
    protected $name = 'core:publish-auth';

    /**
     * The console command description.
     */
    protected $description = 'Publish core auth config files.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->publishCommand('config-auth');
    }
}