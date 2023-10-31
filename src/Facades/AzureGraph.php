<?php

namespace ChrisReedIO\AzureGraph\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ChrisReedIO\AzureGraph\AzureGraph
 */
class AzureGraph extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ChrisReedIO\AzureGraph\AzureGraph::class;
    }
}
