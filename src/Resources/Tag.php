<?php

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Entities\Tag as TagEntity;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Tag extends Model
{
    /**
     * @throws BaseException|GuzzleException
     */
    public function index(): array
    {
        return $this->connection->requestAndParse(
            'GET',
            'tag'
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function get(string $tagId): TagEntity
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'tag/'.urlencode(trim($tagId))
        );

        return new TagEntity($data);
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function create(string $name): array
    {
        return $this->connection->requestAndParse(
            'POST',
            'tag/',
            [
                RequestOptions::FORM_PARAMS => [
                    'name'    => trim($name)
                ]
            ]
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function update(string $tagId, string $newName): array
    {
        return $this->connection->requestAndParse(
            'PUT',
            'tag/'.urlencode(trim($tagId)),
            [
                RequestOptions::FORM_PARAMS => [
                    'name'    => trim($newName)
                ]
            ]
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function delete(string $tagId): array
    {
        return $this->connection->requestAndParse(
            'DELETE',
            'tag/'.urlencode(trim($tagId))
        );
    }
}
