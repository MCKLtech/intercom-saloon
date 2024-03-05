<?php

namespace WooNinja\IntercomSaloon\Services\Objects;


use Saloon\Http\Response;
use WooNinja\IntercomSaloon\DataTransferObjects\DataEvents\CreateDataEvent;
use WooNinja\IntercomSaloon\Requests\DataEvents\Create;
use WooNinja\IntercomSaloon\Services\Resource;

class DataEventService extends Resource
{
    public function create(CreateDataEvent $event): Response {

        return $this->connector
            ->send(new Create($event));

    }

}