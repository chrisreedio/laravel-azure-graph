<?php

namespace ChrisReedIO\AzureGraph\Resources;

// use Saloon\Http\Connector;

use ChrisReedIO\AzureGraph\GraphConnector;

abstract class GraphResource
{
    public function __construct(
        protected GraphConnector $connector,
    ) {
    }
}
