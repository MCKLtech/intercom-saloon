<?php

namespace WooNinja\IntercomSaloon\RateLimiting;

use Saloon\RateLimitPlugin\Contracts\RateLimitStore;

class WordPressRateLimitStore implements RateLimitStore
{

    /**
     * A custom WordPress implementation of the RateLimitStore using WP Transients
     */

    /**
     * Get a rate limit from the store
     */
    public function get(string $key): ?string
    {
        if(!function_exists('get_transient')) {
            return null;
        }

        return get_transient($key);
    }

    public function set(string $key, string $value, int $ttl): bool
    {
        if(!function_exists('set_transient')) {
            return false;
        }

        return set_transient($key, $value, $ttl);
    }
}