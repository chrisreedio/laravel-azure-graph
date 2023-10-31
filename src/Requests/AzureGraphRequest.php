<?php

namespace ChrisReedIO\AzureGraph\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

abstract class AzureGraphRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;
}
