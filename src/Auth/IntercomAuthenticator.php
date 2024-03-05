<?php

namespace WooNinja\IntercomSaloon\Auth;

use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

class IntercomAuthenticator implements Authenticator
{
    public function __construct(
        private readonly string $access_token,

    )
    {
    }

    public function set(PendingRequest $pendingRequest): void
    {
        $pendingRequest->headers()->add('Authorization', 'Bearer ' . $this->access_token);
    }
}