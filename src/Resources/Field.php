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

use D3\KlicktippPhpClient\Entities\Field as FieldEntity;
use D3\KlicktippPhpClient\Entities\FieldList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\RequestOptions;

class Field extends Model
{
    public const ID = 'id';
    public const NAME = 'name';

    /**
     * @throws BaseException
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
     * @throws BaseException
     */
    public function get(string $fieldId): FieldEntity
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'field/'.urlencode(trim($fieldId)).'.json'
        );

        return new FieldEntity($data, $this);
    }

    /**
     * @return string - new field id
     * @throws BaseException
     */
    public function create(string $name): string
    {
        return current(
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
     * @throws BaseException
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
     * @throws BaseException
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
