<?php

namespace ChrisReedIO\AzureGraph\Requests\Users\User\Hierarchy;

use ChrisReedIO\AzureGraph\Data\Users\UserData;
use ChrisReedIO\AzureGraph\Requests\AzureGraphRequest;
use Saloon\Http\Response;

class ListDirectReports extends AzureGraphRequest
{
    /**
     * @param  string  $id  The ID (or user principal name) of the user to retrieve
     */
    public function __construct(
        protected string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/users/'.$this->id.'/directReports';
    }

    public function defaultQuery(): array
    {
        return [
            // '$expand' => 'directReports',
            // '$select' => implode(',', [
            //     'id',
            //     'userPrincipalName',
            //     'displayName',
            //     'givenName',
            //     'surname',
            //     'mobilePhone',
            //     'businessPhones',
            //     'mail',
            //     'department',
            //     'companyName',
            //     'jobTitle',
            //     'officeLocation',
            //     'userType',
            // ]),
        ];
    }

    public function createDtoFromResponse(Response $response): UserData
    {
        return UserData::fromArray($response->json());
    }
}
