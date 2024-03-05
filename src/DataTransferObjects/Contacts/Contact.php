<?php

namespace WooNinja\IntercomSaloon\DataTransferObjects\Contacts;

use Carbon\Carbon;

final class Contact
{
    public function __construct(
        public string $type,
        public string $id,
        public string|null $external_id,
        public string $workspace_id,
        public string $role,
        public string $email,
        public string|null $email_domain,
        public string|null $phone,
        public string|null $formatted_phone,
        public string|null $name,
        public int|null $owner_id,
        public bool $has_hard_bounced,
        public bool $marked_email_as_spam,
        public bool $unsubscribed_from_emails,
        public Carbon $created_at,
        public Carbon $updated_at,
        public Carbon|null $signed_up_at,
        public Carbon|null $last_seen_at,
        public Carbon|null $last_replied_at,
        public Carbon|null $last_contacted_at,
        public Carbon|null $last_email_opened_at,
        public string|null $browser,
        public string|null $browser_version,
        public string|null $browser_language,
        public string|null $os,
        public string|null $android_app_name,
        public string|null $android_device,
        public string|null $android_os_version,
        public string|null $android_sdk_version,
        public Carbon|null $android_last_seen_at,
        public string|null $ios_app_name,
        public string|null $ios_app_version,
        public string|null $ios_device,
        public string|null $ios_os_version,
        public string|null $ios_sdk_version,
        public Carbon|null $ios_last_seen_at,
        public ?array $custom_attributes = [],
        public ?array $tags = [],
        //Notes
        //Companies
        //Location
        //Social_profiles
      )
    {
        //Silence
    }

}