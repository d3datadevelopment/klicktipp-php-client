<?php

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Entities\FieldList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\Exception\GuzzleException;

class Field extends Model
{
    /**
     * @throws BaseException|GuzzleException
     */
    public function index(): FieldList
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'field'
        );

        return new FieldList($data);
    }
}
