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

use D3\KlicktippPhpClient\Entities\Field as FieldEntity;
use D3\KlicktippPhpClient\Entities\FieldList;
use D3\KlicktippPhpClient\Exceptions\CommunicationException;
use D3\KlicktippPhpClient\Exceptions\ResponseContentException;
use GuzzleHttp\RequestOptions;

class Field extends Model
{
    public const ID = 'id';
    public const NAME = 'name';

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function index(): FieldList
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'field.json'
        );

        return new FieldList($data);
    }

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function get(string $fieldId): array
    {
        return $this->connection->requestAndParse(
            'GET',
            'field/'.urlencode(trim($fieldId)).'.json'
        );
    }

    /**
     * @throws CommunicationException
     */
    public function getEntity(string $fieldId): FieldEntity
    {
        return new FieldEntity($this->get($fieldId), $this);
    }

    /**
     * @return string - new field id
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function create(string $name): string
    {
        return (string) current(
            $this->connection->requestAndParse(
                'POST',
                'field.json',
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
    public function update(string $fieldId, ?string $name = null): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'PUT',
                'field/'.urlencode(trim($fieldId)).'.json',
                [
                    RequestOptions::FORM_PARAMS => array_filter([
                        self::NAME    => trim($name ?? ''),
                    ]),
                ]
            )
        );
    }

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function delete(string $fieldId): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'DELETE',
                'field/'.urlencode(trim($fieldId)).'.json'
            )
        );
    }
}
