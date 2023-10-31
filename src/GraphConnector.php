<?php

namespace App\Http\Integrations\AzureGraph;

use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\CursorPaginator;
use Saloon\PaginationPlugin\Paginator;
use Saloon\Traits\Plugins\AcceptsJson;

class GraphConnector extends Connector implements HasPagination
{
    use AcceptsJson;

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

	public function  __construct(protected string $token)
	{
		$this->withTokenAuth($this->token);
	}

	public function paginate(Request $request): Paginator
	{
		return new class(connector: $this, request: $request) extends CursorPaginator
        {
			protected ?int $perPageLimit = 100;

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
                return (array)$response->json('value');
            }

			protected function applyPagination(Request $request): Request
			{
				if (isset($this->perPageLimit)) {
					$request->query()->add('$top', $this->perPageLimit);
				}

				if ($this->currentResponse instanceof Response) {
					$token = $this->getNextCursor($this->currentResponse);
					$request->query()->add('$skiptoken', $token);
				}
				
				return $request;
			}
        };
	}
}
