<?php

namespace WooNinja\IntercomSaloon\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use WooNinja\IntercomSaloon\DataTransferObjects\Tags\Tag;

class Tags extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $intercom_id
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->intercom_id}/tags";
    }

    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $tag) {
            return new Tag(
                type: $tag['type'],
                id: $tag['id'],
                name: $tag['name'],
            );
        }, $response->json('data'));
    }

}