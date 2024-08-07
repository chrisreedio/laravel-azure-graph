<?php

namespace ChrisReedIO\AzureGraph\Requests\Users\Group;

use ChrisReedIO\AzureGraph\Data\Groups\GroupData;
use ChrisReedIO\AzureGraph\Requests\AzureGraphRequest;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class MemberOfRequest extends AzureGraphRequest implements Paginatable
{
    /**
     * @param  null|string  $userId  If null, the request will be made for the current user
     */
    public function __construct(protected ?string $userId = null) {}

    public function resolveEndpoint(): string
    {
        if ($this->userId) {
            return "/users/{$this->userId}/memberOf";
        }

        return '/me/memberOf';
    }

    public function createDtoFromResponse(Response $response): array
    {
        return collect($response->json('value'))
            ->map(fn (array $data) => GroupData::fromArray($data))
            ->all();
    }
}
