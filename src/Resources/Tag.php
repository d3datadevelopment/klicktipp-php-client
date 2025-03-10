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

declare(strict_types=1);

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Entities\Tag as TagEntity;
use D3\KlicktippPhpClient\Entities\TagList;
use D3\KlicktippPhpClient\Exceptions\CommunicationException;
use D3\KlicktippPhpClient\Exceptions\ResponseContentException;
use GuzzleHttp\RequestOptions;

class Tag extends Model
{
    public const ID = 'tagid';
    public const NAME = 'name';
    public const TEXT = 'text';

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
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
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function get(string $tagId): array
    {
        return $this->connection->requestAndParse(
            'GET',
            'tag/'.urlencode(trim($tagId)).'.json'
        );
    }

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function getEntity(string $tagId): TagEntity
    {
        return new TagEntity($this->get($tagId), $this);
    }

    /**
     * @return string - new tag id
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function create(string $name): string
    {
        return (string) current(
            $this->connection->requestAndParse(
                'POST',
                'tag.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        self::NAME    => trim($name),
                    ],
                ]
            )
        );
    }

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function update(string $tagId, ?string $name = null, ?string $text = null): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'PUT',
                'tag/'.urlencode(trim($tagId)).'.json',
                [
                    RequestOptions::FORM_PARAMS => array_filter([
                        self::NAME    => trim($name ?? ''),
                        self::TEXT    => trim($text ?? ''),
                    ]),
                ]
            )
        );
    }

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
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
