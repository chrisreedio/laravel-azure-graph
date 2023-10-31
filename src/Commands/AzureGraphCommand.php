<?php

namespace ChrisReedIO\AzureGraph\Commands;

use Illuminate\Console\Command;

class AzureGraphCommand extends Command
{
    public $signature = 'laravel-azure-graph';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
