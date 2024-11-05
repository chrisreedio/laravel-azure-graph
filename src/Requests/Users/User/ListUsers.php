<?php

namespace ChrisReedIO\AzureGraph\Requests\Users\User;

use ChrisReedIO\AzureGraph\Data\Users\UserData;
use ChrisReedIO\AzureGraph\Requests\AzureGraphRequest;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

use function implode;

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
            '$expand' => 'manager($select='.implode(',', [
                'id',
                'accountEnabled',
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
                'city',
                'officeLocation',
                'userType',
                'employeeId',
            ]).')',
            '$select' => implode(',', [
                'id',
                'accountEnabled',
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
                'city',
                'officeLocation',
                'userType',
                'employeeId',
            ]),
        ];
        // return [
        //     '$select' => implode(',', [
        //         'id',
        //         'userPrincipalName',
        //         'displayName',
        //         'givenName',
        //         'surname',
        //         'mobilePhone',
        //         'businessPhones',
        //         'mail',
        //         'department',
        //         'companyName',
        //         'jobTitle',
        //         'officeLocation',
        //         'userType',
        //         'EmployeeID',
        //     ]),
        // ];
    }

    public function createDtoFromResponse(Response $response): array
    {
        // dd($response->json());

        // return UserData::fromArray($response->json());
        return collect($response->json('value'))
            ->map(fn ($user) => UserData::fromArray($user))->toArray();
    }
}
