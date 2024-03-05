<?php

namespace WooNinja\IntercomSaloon\Requests\DataEvents;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use WooNinja\IntercomSaloon\DataTransferObjects\DataEvents\CreateDataEvent;

class Create extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly CreateDataEvent $createDataEvent
    )
    {
    }

    protected function defaultBody(): array
    {
        $body = [
            'event_name' => $this->createDataEvent->event_name,
            'created_at' => $this->createDataEvent->created_at->getTimestamp(),
            'meta_data' => $this->createDataEvent->metadata,
        ];

        if(filter_var($this->createDataEvent->intercom_user_id_or_email, FILTER_VALIDATE_EMAIL)) {
            $body['email'] = $this->createDataEvent->intercom_user_id_or_email;
        }else {
            $body['id'] = $this->createDataEvent->intercom_user_id_or_email;
        }

        return $body;
    }


    public function resolveEndpoint(): string
    {
        return 'events';
    }
}