<?php

namespace WooNinja\IntercomSaloon\Services\Objects;

use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\CursorPaginator;
use WooNinja\IntercomSaloon\DataTransferObjects\Contacts\Contact;
use WooNinja\IntercomSaloon\DataTransferObjects\Contacts\CreateContact;
use WooNinja\IntercomSaloon\DataTransferObjects\Contacts\UpdateContact;
use WooNinja\IntercomSaloon\Requests\Contacts\Contacts;
use WooNinja\IntercomSaloon\Requests\Contacts\Create;
use WooNinja\IntercomSaloon\Requests\Contacts\Delete;
use WooNinja\IntercomSaloon\Requests\Contacts\Get;
use WooNinja\IntercomSaloon\Requests\Contacts\Note;
use WooNinja\IntercomSaloon\Requests\Contacts\Search;
use WooNinja\IntercomSaloon\Requests\Contacts\Tags;
use WooNinja\IntercomSaloon\Requests\Contacts\Update;
use WooNinja\IntercomSaloon\Services\Resource;
use \WooNinja\IntercomSaloon\DataTransferObjects\Notes\Note as IntercomNote;

class ContactService extends Resource
{

    /**
     * Return a list of all Intercom Contacts
     *
     * @return CursorPaginator
     */
    public function contacts(): CursorPaginator
    {
        return $this->connector
            ->paginate(new Contacts());
    }

    /**
     * Create an Intercom Contact
     *
     * @param CreateContact $contact
     * @return Contact
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function create(CreateContact $contact): Contact
    {
        return $this->connector
            ->send(new Create($contact))
            ->dtoOrFail();
    }

    /**
     * Fetch a single Intercom Contact by Intercom Assigned ID
     *
     * @param string $intercom_id
     * @return Contact
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function get(string $intercom_id): Contact
    {
        return $this->connector
            ->send(new Get($intercom_id))
            ->dtoOrFail();
    }

    /**
     * Update an Intercom Contact by Intercom Assigned ID
     *
     * @param string $intercom_id
     * @param UpdateContact $contact
     * @return Contact
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function update(string $intercom_id, UpdateContact $contact): Contact
    {
        return $this->connector
            ->send(new Update($intercom_id, $contact))
            ->dtoOrFail();
    }

    /**
     * Delete a Contact by Intercom Assigned ID
     *
     * @param string $intercom_id
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function delete(string $intercom_id): Response
    {
        return $this->connector
            ->send(new Delete($intercom_id));

    }

    /**
     * Search Intercom by Email. Option to search for exact match
     *
     * @param string $email
     * @param bool $exact
     * @return CursorPaginator
     */
    public function searchByEmail(string $email, bool $exact = true): CursorPaginator
    {
        return $this->connector
            ->paginate(new Search($email, $exact));
    }

    /**
     * Return tags associated with a given Intercom Contact by Assigned Intercom ID
     *
     * @param string $intercom_id
     * @return CursorPaginator
     */
    public function tags(string $intercom_id): CursorPaginator
    {
        return $this->connector
            ->paginate(new Tags($intercom_id));
    }

    /**
     * Add a note to a given Intercom Contact by Assigned Intercom ID
     *
     * @param string $intercom_id
     * @param string $body
     * @param string|null $contact_id
     * @param string|null $admin_id
     * @return \WooNinja\IntercomSaloon\DataTransferObjects\Notes\Note
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function note(string $intercom_id, string $body, string|null $contact_id = null, string|null $admin_id = null): IntercomNote
    {
        return $this->connector
            ->send(new Note($intercom_id, $body, $contact_id, $admin_id))
            ->dtoOrFail();
    }
}