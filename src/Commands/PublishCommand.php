<?php

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
    public function fire(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'Raid\Core\Providers\CoreServiceProvider',
//            '--tag' => 'config'
        ]);
    }
}