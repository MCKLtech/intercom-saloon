<?php

namespace WooNinja\IntercomSaloon\DataTransferObjects\Contacts;

use Carbon\Carbon;

final class CreateContact
{
    public function __construct(
        public string  $email,
        public ?string $name = null,
        public ?string $external_id = null,
        public ?string $phone = null,
        public ?string $avatar = null,
        public ?Carbon $signed_up_at = null,
        public ?Carbon $last_seen_at = null,
        public ?string $owner_id = null,
        public ?string $role = null,
        public ?bool   $unsubscribed_from_emails = null,
        public ?array  $custom_attributes = null,
    )
    {
        // Silence is golden
    }
}
