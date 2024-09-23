<?php

namespace ChrisReedIO\AzureGraph\Requests\Users\User;

use ChrisReedIO\AzureGraph\Data\Users\UserData;
use ChrisReedIO\AzureGraph\Requests\AzureGraphRequest;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class ListUsers extends AzureGraphRequest implements Paginatable
{
    public function __construct() {}

    public function resolveEndpoint(): string
    {
        return '/users';
    }

    public function defaultQuery(): array
    {
        return [
            '$select' => implode(',', [
                'id',
                'userPrincipalName',
                'displayName',
                'givenName',
                'surname',
                'mobilePhone',
                'businessPhones',
                'mail',
                'department',
                'companyName',
                'jobTitle',
                'officeLocation',
                'userType',
                'EmployeeID',
            ]),
        ];
    }

    public function createDtoFromResponse(Response $response): UserData
    {
        dd($response->json());
        return UserData::fromArray($response->json());
    }
}
