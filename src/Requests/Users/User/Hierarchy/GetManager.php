<?php

namespace ChrisReedIO\AzureGraph\Requests\Users\User\Hierarchy;

use ChrisReedIO\AzureGraph\Data\Users\UserData;
use ChrisReedIO\AzureGraph\Requests\AzureGraphRequest;
use Saloon\Http\Response;

use function implode;

class GetManager extends AzureGraphRequest
{
    /**
     * @param  string  $id  The ID (or user principal name) of the user to retrieve
     */
    public function __construct(
        protected string $id,
        protected string $levels = 'max',
    ) {}

    public function resolveEndpoint(): string
    {
        return '/users/'.$this->id;
    }

    protected function defaultHeaders(): array
    {
        return [
            'ConsistencyLevel' => 'eventual',
        ];
    }

    public function defaultQuery(): array
    {
        return [
            '$expand' => 'manager($levels='.$this->levels.';$select='.implode(',', [
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
    }

    public function createDtoFromResponse(Response $response): UserData
    {
        return UserData::fromArray($response->json());
    }
}
