<?php

namespace ChrisReedIO\AzureGraph;

use ChrisReedIO\AzureGraph\Resources\UserResource;
use ReflectionException;
use Saloon\Exceptions\OAuthConfigValidationException;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\CursorPaginator;
use Saloon\PaginationPlugin\Paginator;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;
use Saloon\Traits\Plugins\AcceptsJson;
use Throwable;
use function config;
use function dd;

class GraphConnector extends Connector implements HasPagination
{
    use ClientCredentialsGrant;
    use AcceptsJson;

    /**
     * The default number of items per page
     */
    protected ?int $perPageLimit = null;

    protected ?string $loginBaseUrl = 'https://login.microsoftonline.com';

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://graph.microsoft.com/v1.0';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }

    public function __construct(protected ?string $token = null)
    {
        if ($token) {
            $this->withTokenAuth($this->token);
        } else {
            // Attempt to set up authentication
            try {
                $authenticator = $this->getAccessToken();
                $this->authenticate($authenticator);
            } catch (Throwable $e) {
                throw new \Exception('Athena SDK failed to authenticate: ' . $e->getMessage());
            }
        }
        $this->perPageLimit = config('azure-graph.pagination.limit');
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        $tenantId = config('services.azure.tenant_id') ?? config('services.azure.tenant');
        if (!$tenantId) {
            throw new OAuthConfigValidationException('No tenant ID provided.');
        }
        $loginUrl = $this->loginBaseUrl . '/' . $tenantId . '/oauth2/v2.0/token';
        return OAuthConfig::make()
            ->setClientId(config('services.azure.client_id'))
            ->setClientSecret(config('services.azure.client_secret'))
            ->setTokenEndpoint($loginUrl)
            ->setDefaultScopes(['https://graph.microsoft.com/.default']);
    }

    public function paginate(Request $request): Paginator
    {
        return new class(connector: $this, request: $request) extends CursorPaginator {
            protected ?int $perPageLimit = 500;

            protected function getNextCursor(Response $response): int|string
            {
                $nextLink = (string)$response->json('@odata.nextLink');
                // Get the token off the end
                $token = explode('skiptoken=', $nextLink)[1];

                return $token;
            }

            protected function isLastPage(Response $response): bool
            {
                return is_null($response->json('@odata.nextLink'));
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                // return (array)$response->json('value');
                try {
                    $dtoResult = $response->dtoOrFail();
                } catch (Throwable $e) {
                    // throw new \Exception(class_basename($request).' failed to parse response body as JSON: '.$e->getMessage());
                    dd($e->getMessage());
                }
                if (! $dtoResult) {
                    return $response->json('value');
                    // throw new \Exception('Failed to parse response body as JSON.');
                }

                return $dtoResult;
            }

            protected function applyPagination(Request $request): Request
            {
                $configPerPageLimit = config('azure-graph.pagination.limit');
                $pageLimit = $configPerPageLimit ?? $this->perPageLimit;
                if ($pageLimit) {
                    $request->query()->add('$top', $pageLimit);
                }

                if ($this->currentResponse instanceof Response) {
                    $token = $this->getNextCursor($this->currentResponse);
                    $request->query()->add('$skiptoken', $token);
                }

                return $request;
            }
        };
    }

    // Resources
    public function users(): UserResource
    {
        return new UserResource($this);
    }
    // End Resources
}
