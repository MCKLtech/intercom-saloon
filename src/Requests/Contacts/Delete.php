<?php

namespace WooNinja\IntercomSaloon\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class Delete extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $intercom_id
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->intercom_id}";
    }

}