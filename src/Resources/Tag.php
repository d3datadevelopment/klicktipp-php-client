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
use GuzzleHttp\RequestOptions;

class Tag extends Model
{
    /**
     * @throws BaseException
     */
    public function index(): TagList
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'tag.json'
        );

        return new TagList($data);
    }

    /**
     * @throws BaseException
     */
    public function get(string $tagId): TagEntity
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'tag/'.urlencode(trim($tagId)).'.json'
        );

        return new TagEntity($data);
    }

    /**
     * @return string - new tag id
     * @throws BaseException
     */
    public function create(string $name): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'tag.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        'name'    => trim($name),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function update(string $tagId, string $newName): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'PUT',
                'tag/'.urlencode(trim($tagId)).'.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        'name'    => trim($newName),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function delete(string $tagId): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'DELETE',
                'tag/'.urlencode(trim($tagId)).'.json'
            )
        );
    }
}
