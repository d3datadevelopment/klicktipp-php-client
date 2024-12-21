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
            'tag',
            [
                'query' => $this->getQuery()
            ]
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function get(string $tagId): TagEntity
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'tag/'.urlencode(trim($tagId)),
            [
                RequestOptions::QUERY   => $this->getQuery()
            ]
        );

        return new TagEntity($data);
    }
}
