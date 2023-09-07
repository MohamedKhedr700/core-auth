<?php

namespace Raid\Core\Auth\Commands;

use \Illuminate\Console\Command;
class PublishCommand extends Command
{
    /**
     * The console command name.
     */
    protected $name = 'publish:raid-auth';

    /**
     * The console command description.
     */
    protected $description = 'Publish Raid auth config files.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--tag' => 'config-auth'
        ]);
    }
}