<?php

namespace ChrisReedIO\AzureGraph\Requests\Users\User;

use ChrisReedIO\AzureGraph\Data\Users\UserData;
use ChrisReedIO\AzureGraph\Requests\AzureGraphRequest;
use JsonException;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class UserDelta extends AzureGraphRequest implements Paginatable
{
    public function resolveEndpoint(): string
    {
        return '/users/delta';
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
            ]),
        ];
    }

    /**
     * @return array<UserData>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return collect($response->json('value'))
            ->map(fn ($user) => UserData::fromArray($user))
            ->all();
    }
}
