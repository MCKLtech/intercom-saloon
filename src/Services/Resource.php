<?php

namespace WooNinja\IntercomSaloon\Services;

use WooNinja\IntercomSaloon\Connectors\IntercomConnector;

abstract class Resource
{

    /**
     * @var IntercomService
     */
    protected IntercomService $service;

    protected IntercomConnector $connector;

    /**
     * IntercomService constructor.
     *
     * @param IntercomService $service
     */
    public function __construct(IntercomService $service)
    {
        $this->service = $service;

        $this->connector = $this->service->connector();
    }
}