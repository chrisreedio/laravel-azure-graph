<?php

namespace ChrisReedIO\AzureGraph\Requests\Users\Group;

use ChrisReedIO\AzureGraph\Requests\AzureGraphRequest;

class MemberOfRequest extends AzureGraphRequest
{
	public function __construct(protected ?string $userId)
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
