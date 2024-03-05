<?php

namespace WooNinja\IntercomSaloon\DataTransferObjects\Tags;

use Carbon\Carbon;

class Tag
{
    public function __construct(
        public string $type,
        public string $id,
        public string $name,
        public ?Carbon $applied_at = null
    )
    {
    }

}