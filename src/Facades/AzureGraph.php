<?php

namespace ChrisReedIO\AzureGraph\Facades;

use ChrisReedIO\AzureGraph\GraphConnector;
use Illuminate\Support\Facades\Facade;

/**
 * @see GraphConnector
 */
class AzureGraph extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GraphConnector::class;
    }
}
