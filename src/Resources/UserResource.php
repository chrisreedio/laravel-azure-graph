<?php

namespace ChrisReedIO\AzureGraph\Resources;

use ChrisReedIO\AzureGraph\Data\Groups\GroupData;
use ChrisReedIO\AzureGraph\Data\Users\UserData;
use ChrisReedIO\AzureGraph\Requests\Users\Group\MemberOfRequest;
use ChrisReedIO\AzureGraph\Requests\Users\User\GetUser;
use ChrisReedIO\AzureGraph\Requests\Users\User\GetUserByEmployeeId;
use ChrisReedIO\AzureGraph\Requests\Users\User\Hierarchy\GetManager;
use ChrisReedIO\AzureGraph\Requests\Users\User\Hierarchy\ListDirectReports;
use ChrisReedIO\AzureGraph\Requests\Users\User\UserDelta;
use Illuminate\Support\LazyCollection;

class UserResource extends GraphResource
{
    /**
     * @return LazyCollection<UserData>
     */
    public function deltas(): LazyCollection
    {
        return $this->connector->paginate(new UserDelta)->collect();
    }

    /**
     * @param  string|null  $id  If null, the request will be made for the current user
     *                           (Will fail if performing a non-delegated call)
     * @return LazyCollection<GroupData>
     */
    public function groups(?string $id = null): LazyCollection
    {
        return $this->connector->paginate(new MemberOfRequest($id))->collect();
    }

    public function get(string $id): ?UserData
    {
        return $this->connector->send(new GetUser($id))->dtoOrFail();
    }

    public function getByEmployeeId(string $employeeId): ?UserData
    {
        return $this->connector->send(new GetUserByEmployeeId($employeeId))->dtoOrFail();
    }

    public function managers(string $id): \Saloon\Http\Response
    {
        return $this->connector->send(new GetManager($id));
    }

    public function directReports(string $id): \Saloon\Http\Response
    {
        return $this->connector->send(new ListDirectReports($id));
    }
}
