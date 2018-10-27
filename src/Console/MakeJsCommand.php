<?php

namespace Jijoel\AuthApi\Console;

use Illuminate\Console\Command;

class MakeJsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-js';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold front-end resources for api authentication';

    /**
     * Execute the console command.
     *
     * @param  \Laravel\Passport\ClientRepository  $clients
     * @return void
     */
    public function handle()
    {
        $this->info('Handling make js');
        $this->line('<comment>This feature has not been implemented yet</comment>');
        return;
    }

}
