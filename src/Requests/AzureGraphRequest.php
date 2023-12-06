<?php

namespace ChrisReedIO\AzureGraph\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

abstract class AzureGraphRequest extends Request
{
    protected Method $method = Method::GET;
}
