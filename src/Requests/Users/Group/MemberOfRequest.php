<?php

namespace ChrisReedIO\AzureGraph\Requests\Users\Group;

use ChrisReedIO\AzureGraph\Requests\AzureGraphRequest;

class MemberOfRequest extends AzureGraphRequest
{
    /**
     * @param  null|string  $userId If null, the request will be made for the current user
     */
    public function __construct(protected ?string $userId = null)
    {
    }

    public function resolveEndpoint(): string
    {
        if ($this->userId) {
            return "/users/{$this->userId}/memberOf";
        }

        return '/me/memberOf';
    }
}
