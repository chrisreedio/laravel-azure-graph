<?php

namespace ChrisReedIO\AzureGraph\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ChrisReedIO\AzureGraph\GraphConnector
 */
class AzureGraph extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ChrisReedIO\AzureGraph\GraphConnector::class;
    }
}
