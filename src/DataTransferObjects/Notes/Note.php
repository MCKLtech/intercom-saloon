<?php

namespace WooNinja\IntercomSaloon\DataTransferObjects\Notes;

use Carbon\Carbon;

class Note
{
    public function __construct(
        public string $type,
        public string $body,
        public int    $id,
        public Carbon $created_at,
        public ?array $contact = null,
        public ?array $author = null,
    )
    {

    }

}