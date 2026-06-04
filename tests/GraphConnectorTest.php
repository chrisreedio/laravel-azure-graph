<?php

use ChrisReedIO\AzureGraph\Data\Groups\GroupData;
use ChrisReedIO\AzureGraph\Data\Users\UserData;
use ChrisReedIO\AzureGraph\GraphConnector;
use ChrisReedIO\AzureGraph\Requests\Users\User\GetUser;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('sends graph requests with token auth and json headers', function () {
    $connector = new GraphConnector('delegated-token');
    $mockClient = new MockClient([
        GetUser::class => MockResponse::make([
            'id' => 'user-1',
            'displayName' => 'Ada Lovelace',
            'userPrincipalName' => 'ada@example.com',
        ]),
    ]);

    $connector->withMockClient($mockClient);

    $user = $connector->users()->get('user-1');
    $psrRequest = $mockClient->getLastResponse()?->getPsrRequest();

    expect($user)->toBeInstanceOf(UserData::class)
        ->and($user->id)->toBe('user-1')
        ->and($user->displayName)->toBe('Ada Lovelace')
        ->and($psrRequest?->getHeaderLine('Authorization'))->toBe('Bearer delegated-token')
        ->and($psrRequest?->getHeaderLine('Accept'))->toBe('application/json')
        ->and($psrRequest?->getUri()->getScheme())->toBe('https')
        ->and($psrRequest?->getUri()->getHost())->toBe('graph.microsoft.com')
        ->and($psrRequest?->getUri()->getPath())->toBe('/v1.0/users/user-1');
});

it('configures the oauth client credentials endpoint for microsoft login', function () {
    config()->set('services.azure.tenant_id', 'tenant-123');
    config()->set('services.azure.client_id', 'client-123');
    config()->set('services.azure.client_secret', 'secret-123');

    $connector = new class('delegated-token') extends GraphConnector
    {
        public function oauthConfigForTesting(): OAuthConfig
        {
            return $this->defaultOauthConfig();
        }
    };

    $config = $connector->oauthConfigForTesting();

    expect($config->getClientId())->toBe('client-123')
        ->and($config->getClientSecret())->toBe('secret-123')
        ->and($config->getTokenEndpoint())->toBe('https://login.microsoftonline.com/tenant-123/oauth2/v2.0/token')
        ->and($config->getDefaultScopes())->toBe(['https://graph.microsoft.com/.default']);

    if (method_exists($config, 'getAllowBaseUrlOverride')) {
        expect($config->getAllowBaseUrlOverride())->toBeTrue();
    }
});

it('paginates microsoft graph cursor responses', function () {
    config()->set('azure-graph.pagination.limit', 2);

    $connector = new GraphConnector('delegated-token');
    $mockClient = new MockClient([
        MockResponse::make([
            'value' => [
                [
                    'id' => 'group-1',
                    'displayName' => 'First Group',
                ],
            ],
            '@odata.nextLink' => 'https://graph.microsoft.com/v1.0/me/memberOf?$skiptoken=next-token',
        ]),
        MockResponse::make([
            'value' => [
                [
                    'id' => 'group-2',
                    'displayName' => 'Second Group',
                ],
            ],
        ]),
    ]);

    $connector->withMockClient($mockClient);

    $groups = $connector->users()->groups()->all();
    $requests = collect($mockClient->getRecordedResponses())
        ->map(fn ($response) => $response->getPsrRequest());

    expect($groups)->toHaveCount(2)
        ->and($groups[0])->toBeInstanceOf(GroupData::class)
        ->and($groups[0]->displayName)->toBe('First Group')
        ->and($groups[1]->displayName)->toBe('Second Group')
        ->and($requests)->toHaveCount(2)
        ->and($requests[0]->getUri()->getPath())->toBe('/v1.0/me/memberOf')
        ->and($requests[0]->getUri()->getQuery())->toBe('%24top=2')
        ->and($requests[1]->getUri()->getPath())->toBe('/v1.0/me/memberOf')
        ->and($requests[1]->getUri()->getQuery())->toBe('%24top=2&%24skiptoken=next-token');
});
