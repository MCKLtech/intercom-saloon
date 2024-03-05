<?php

namespace WooNinja\IntercomSaloon\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use WooNinja\IntercomSaloon\DataTransferObjects\Contacts\Contact;
use Carbon\Carbon;

class Contacts extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "contacts";
    }

    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $contact) {
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

            );
        }, $response->json('data'));
    }

}