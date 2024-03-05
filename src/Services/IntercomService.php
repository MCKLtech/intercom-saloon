<?php

namespace WooNinja\IntercomSaloon\Services;

use Saloon\Contracts\Authenticator;
use WooNinja\IntercomSaloon\Auth\IntercomAuthenticator;
use WooNinja\IntercomSaloon\Connectors\IntercomConnector;
use WooNinja\IntercomSaloon\Interfaces\Intercom;
use WooNinja\IntercomSaloon\Services\Objects\ContactService;
use WooNinja\IntercomSaloon\Services\Objects\DataEventService;
use WooNinja\IntercomSaloon\Services\Objects\TagService;

final class IntercomService implements Intercom
{
    private IntercomConnector|bool $connector = false;

    private Authenticator|bool $authenticator = false;

    public ContactService $contacts;

    public TagService $tags;

    public DataEventService $dataEvents;

    public function __construct(private readonly string $access_token)
    {
        $this->contacts = new ContactService($this);
        $this->tags = new TagService($this);
        $this->dataEvents = new DataEventService($this);
    }

    /**
     * Dynamically set the Connector
     *
     * @param IntercomConnector $connector
     * @return void
     */
    public function setConnector(IntercomConnector $connector): void
    {
        $this->connector = $connector;
    }

    /**
     * @return IntercomConnector
     */
    public function connector(): IntercomConnector
    {
        if ($this->connector) {
            return $this->connector;
        }

        /**
         * Default Connector
         */
        return (new IntercomConnector())
            ->authenticate($this->authenticator());

    }

    /**
     * Dynamically set the Authenticator
     *
     * @param Authenticator $authenticator
     * @return void
     */
    public function setAuthenticator(Authenticator $authenticator): void
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @return Authenticator
     */
    public function authenticator(): Authenticator
    {
        if ($this->authenticator) {
            return $this->authenticator;
        }

        return new IntercomAuthenticator(
            $this->access_token
        );
    }

}