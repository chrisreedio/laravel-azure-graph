<?php

namespace ChrisReedIO\AzureGraph\Resources;

use ChrisReedIO\AzureGraph\Data\Users\UserData;
use ChrisReedIO\AzureGraph\Requests\Users\Group\MemberOfRequest;
use ChrisReedIO\AzureGraph\Requests\Users\User\GetUser;
use ChrisReedIO\AzureGraph\Requests\Users\User\UserDelta;
use Illuminate\Support\LazyCollection;

class UserResource extends GraphResource
{
    /**
     * @return LazyCollection<UserData>
     */
    public function deltas(): LazyCollection
    {
        return $this->connector->paginate(new UserDelta())->collect();
    }

    public function groups()
    {
        $response = $this->connector->send(new MemberOfRequest());

        return $response->json();
    }

    public function get(string $id): ?UserData
    {
        return $this->connector->send(new GetUser($id))->dtoOrFail();
    }
}
