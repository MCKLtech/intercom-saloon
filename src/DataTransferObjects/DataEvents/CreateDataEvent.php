<?php

namespace WooNinja\IntercomSaloon\DataTransferObjects\DataEvents;

use Carbon\Carbon;

final class CreateDataEvent
{
    public function __construct(
        public string $event_name,
        public string $intercom_user_id_or_email, //Intercom provided ID or contact email (must be unique)
        public array $metadata,
        public Carbon $created_at,
    )
    {
    }
}