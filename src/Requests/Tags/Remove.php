<?php

namespace WooNinja\IntercomSaloon\Requests\Tags;

use Carbon\Carbon;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use WooNinja\IntercomSaloon\DataTransferObjects\Tags\Tag;

class Remove extends Request
{


    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $intercom_id,
        private readonly string $tag_id
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->intercom_id}/tags/{$this->tag_id}";
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        $tag = $response->json();

        return new Tag(
            type: $tag['type'],
            id: $tag['id'],
            name: $tag['name'],
            applied_at: Carbon::parse($tag['applied_at'])
        );
    }

}