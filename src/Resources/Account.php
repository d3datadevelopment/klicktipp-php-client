<?php

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Account extends Model
{
    /**
     * @throws BaseException|GuzzleException
     */
    public function login(): array
    {
        $response = $this->connection->request(
            'POST',
            'account/login',
            [
                RequestOptions::FORM_PARAMS => [
                    'username' => $this->connection->getClientKey(),
                    'password' => $this->connection->getSecretKey()
                ]
            ]
        );

        return $this->connection->parseResponse($response);
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function logout(): bool
    {
        $response = $this->connection->requestAndParse(
            'POST',
            'account/logout'
        );

        return (bool) current($response);
    }
}
