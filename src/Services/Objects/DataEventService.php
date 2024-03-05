<?php

namespace WooNinja\IntercomSaloon\Services\Objects;


use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Response;
use WooNinja\IntercomSaloon\DataTransferObjects\DataEvents\CreateDataEvent;
use WooNinja\IntercomSaloon\Requests\DataEvents\Create;
use WooNinja\IntercomSaloon\Services\Resource;

class DataEventService extends Resource
{
    /**
     * Submit a Data Event to Intercom
     * @see https://developers.intercom.com/docs/references/rest-api/api.intercom.io/Data-Events/createDataEvent/
     *
     * @param CreateDataEvent $event
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function create(CreateDataEvent $event): Response {

        return $this->connector
            ->send(new Create($event));

    }

}