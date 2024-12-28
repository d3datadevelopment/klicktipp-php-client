<?php

/**
 * Copyright (c) D3 Data Development (Inh. Thomas Dartsch)
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <info@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Entities\Tag as TagEntity;
use D3\KlicktippPhpClient\Entities\TagList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Tag extends Model
{
    /**
     * @throws BaseException|GuzzleException
     */
    public function index(): TagList
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'tag'
        );

        return new TagList($data);
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
                    'name'    => trim($name),
                ],
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
                    'name'    => trim($newName),
                ],
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
