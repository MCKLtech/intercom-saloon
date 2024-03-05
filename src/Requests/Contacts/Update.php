<?php

namespace WooNinja\IntercomSaloon\Requests\Contacts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use WooNinja\IntercomSaloon\DataTransferObjects\Contacts\Contact;
use Carbon\Carbon;
use WooNinja\IntercomSaloon\DataTransferObjects\Contacts\UpdateContact;
use WooNinja\IntercomSaloon\Traits\RequestTrait;

class Update extends Request implements HasBody
{
    use HasJsonBody;
    use RequestTrait;

    protected Method $method = Method::PUT;

    public function __construct(
        private readonly string $intercom_id,
        private readonly UpdateContact $contact
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->intercom_id}";
    }

    protected function defaultBody(): array
    {
        $body = [
            'role' => $this->contact->role,
            'external_id' => $this->contact->external_id,
            'email' => $this->contact->email,
            'phone' => $this->contact->phone,
            'name' => $this->contact->name,
            'avatar' => $this->contact->avatar,
            'signed_up_at' => $this->contact->signed_up_at?->getTimestamp(),
            'last_seen_at' => $this->contact->last_seen_at?->getTimestamp(),
            'owner_id' => $this->contact->owner_id,
            'unsubscribed_from_emails' => $this->contact->unsubscribed_from_emails,
            'custom_attributes' => $this->contact->custom_attributes,
        ];

        return $this->removeEmptyArrayValues($body);
    }

    public function createDtoFromResponse(Response $response): Contact
    {
        $contact = $response->json();

        return new Contact(
            type: $contact['type'],
            id: $contact['id'],
            external_id: $contact['external_id'],
            workspace_id: $contact['workspace_id'],
            role: $contact['role'],
            email: $contact['email'],
            email_domain: $contact['email_domain'],
            phone: $contact['phone'],
            formatted_phone: $contact['formatted_phone'],
            name: $contact['name'],
            owner_id: $contact['owner_id'],
            has_hard_bounced: $contact['has_hard_bounced'],
            marked_email_as_spam: $contact['marked_email_as_spam'],
            unsubscribed_from_emails: $contact['unsubscribed_from_emails'],
            created_at: Carbon::parse($contact['created_at']),
            updated_at: Carbon::parse($contact['updated_at']),
            signed_up_at: Carbon::parse($contact['signed_up_at']),
            last_seen_at: Carbon::parse($contact['last_seen_at']),
            last_replied_at: Carbon::parse($contact['last_replied_at']),
            last_contacted_at: Carbon::parse($contact['last_contacted_at']),
            last_email_opened_at: Carbon::parse($contact['last_email_opened_at']),
            browser: $contact['browser'],
            browser_version: $contact['browser_version'],
            browser_language: $contact['browser_language'],
            os: $contact['os'],
            android_app_name: $contact['android_app_name'],
            android_device: $contact['android_device'],
            android_os_version: $contact['android_os_version'],
            android_sdk_version: $contact['android_sdk_version'],
            android_last_seen_at: Carbon::parse($contact['android_last_seen_at']),
            ios_app_name: $contact['ios_app_name'],
            ios_app_version: $contact['ios_app_version'],
            ios_device: $contact['ios_device'],
            ios_os_version: $contact['ios_os_version'],
            ios_sdk_version: $contact['ios_sdk_version'],
            ios_last_seen_at: Carbon::parse($contact['ios_last_seen_at']),
            custom_attributes: $contact['custom_attributes'],
            tags: $contact['tags']
        );
    }

}