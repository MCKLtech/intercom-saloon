<?php

namespace WooNinja\IntercomSaloon\Services\Objects;

use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\PaginationPlugin\CursorPaginator;
use Saloon\PaginationPlugin\PagedPaginator;
use WooNinja\IntercomSaloon\DataTransferObjects\Tags\Tag;
use WooNinja\IntercomSaloon\Requests\Tags\Add;
use WooNinja\IntercomSaloon\Requests\Tags\Remove;
use WooNinja\IntercomSaloon\Requests\Tags\Tags;
use WooNinja\IntercomSaloon\Services\Resource;

class TagService extends Resource
{

    /**
     * List all Tags
     *
     * @return CursorPaginator|PagedPaginator
     */
    public function tags(): PagedPaginator|CursorPaginator
    {
        return $this->connector
            ->paginate(new Tags());
    }

    /**
     * Add a Tag to a Contact in Intercom
     *
     * @param string $intercom_id
     * @param string $tag_id
     * @return Tag
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function add(string $intercom_id, string $tag_id): Tag
    {
        return $this->connector
            ->send(new Add($intercom_id, $tag_id))
            ->dtoOrFail();
    }

    /**
     * Remove a tag from a Contact in Intercom
     *
     * @param string $intercom_id
     * @param string $tag_id
     * @return Tag
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function remove(string $intercom_id, string $tag_id): Tag
    {
        return $this->connector
            ->send(new Remove($intercom_id, $tag_id))
            ->dtoOrFail();
    }
}