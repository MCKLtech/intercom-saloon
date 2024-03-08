<?php

namespace WooNinja\IntercomSaloon\Connectors;

use InvalidArgumentException;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\CursorPaginator;
use Saloon\PaginationPlugin\PagedPaginator;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class IntercomConnector extends Connector implements HasPagination
{

    use AcceptsJson;
    use AlwaysThrowOnErrors;
    use HasRateLimits;

    public bool|RateLimitStore $rateStore = false;

    public int $rateLimit = 1000;

    public int|null $apiVersion = null;

    public string $base_url = 'https://api.intercom.io/';

    public string $region = 'US';

    public function resolveBaseUrl(): string
    {
        return $this->base_url;
    }

    /**
     * Dynamically change the base URL for the API e.g. Regions
     *
     * @param string $url
     * @return void
     */
    public function setBaseURL(string $url): void
    {
        $this->base_url = $url;
    }

    protected function defaultHeaders(): array
    {
        $headers = [
            'User-Agent' => 'WooNinja/Saloon-PHP-SDK'
        ];

        if (is_numeric($this->apiVersion)) {
            $headers['Intercom-Version'] = $this->apiVersion;
        }

        return $headers;
    }

    /**
     * Change the API version. Defaults to latest (null)
     * 
     * @param $version
     * @return void
     */
    public function setApiVersion($version): void
    {
        $this->apiVersion = $version;
    }

    /**
     * Set the API Region
     * Note: US is the default but will also attempt to route to the correct region
     * @see https://developers.intercom.com/docs/build-an-integration/learn-more/rest-apis/
     *
     * @param string $region
     * @return void
     */
    public function setRegion(string $region): void
    {
        $region = strtoupper($region);

        if (in_array($region, ['US', 'EU', 'AU'])) {

            switch ($region) {
                case 'US':
                    $this->setBaseURL('https://api.intercom.io/');
                    break;
                case 'EU':
                    $this->setBaseURL('https://api.eu.intercom.io/');
                    break;
                case 'AU':
                    $this->setBaseURL('https://api.au.intercom.io/');
                    break;
            }

        } else {
            throw new InvalidArgumentException("Invalid region. Intercom API Region must be EU, USA, or AU.");
        }
    }

    /**
     * Get the current region
     *
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    protected function defaultConfig(): array
    {
        return [];
    }

    public function paginate(Request $request): PagedPaginator|CursorPaginator
    {
        return new class(connector: $this, request: $request) extends CursorPaginator {

            protected function getNextCursor(Response $response): int|string
            {
                return $response->json('pages.next');
            }

            protected function isLastPage(Response $response): bool
            {
                return is_null($response->json('pages.next'));
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                return $response->dto();
            }

            protected function applyPagination(Request $request): Request
            {
                if ($this->currentResponse instanceof Response) {
                    $request->query()->add('starting_after', $this->getNextCursor($this->currentResponse));
                }

                if (isset($this->perPageLimit)) {
                    $request->query()->add('per_page', $this->perPageLimit);
                }

                return $request;
            }
        };
    }

    /**
     * Dynamically set the RateLimit Store
     * e.g. new LaravelCacheStore(Cache::store(config('cache.default')));
     *
     * @param RateLimitStore $store
     * @return void
     */
    public function setRateStore(RateLimitStore $store): void
    {
        $this->rateStore = $store;
    }

    /**
     * Dynamically set the rate limit. Intercom plans default to 1000 requests per minute.
     *
     *
     * @param int $limit
     * @return void
     */
    public function setRateLimit(int $limit): void
    {
        $this->rateLimit = $limit;
    }

    protected function resolveLimits(): array
    {
        return [
            Limit::allow(requests: $this->rateLimit, threshold: 0.95)->everyMinute()
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        if ($this->rateStore) return $this->rateStore;

        return new MemoryStore();
    }
}