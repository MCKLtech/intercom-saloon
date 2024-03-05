<?php

namespace WooNinja\IntercomSaloon\Requests\Contacts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Carbon\Carbon;
use WooNinja\IntercomSaloon\Traits\RequestTrait;
use \WooNinja\IntercomSaloon\DataTransferObjects\Notes\Note as IntercomNote;

class Note extends Request implements HasBody
{
    use HasJsonBody;
    use RequestTrait;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $intercom_id,
        private readonly string $text,
        private readonly string|null $contact_id,
        private readonly string|null $admin_id
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->intercom_id}/notes";
    }

    protected function defaultBody(): array
    {
        $body = [
            'body' => $this->text,
            'contact_id' => $this->contact_id,
            'admin_id' => $this->admin_id
        ];

        return $this->removeEmptyArrayValues($body);
    }

    public function createDtoFromResponse(Response $response): IntercomNote
    {
        $note = $response->json();

        return new IntercomNote(
            type: $note['type'],
            body: $note['body'],
            id: $note['id'],
            created_at: Carbon::parse($note['created_at']),
            contact: $note['contact'] ?? null,
            author: $note['author'] ?? null
        );

    }

}