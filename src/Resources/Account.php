<?php

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\Exception\GuzzleException;

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
                'query' => $this->getQuery(),
                'form_params' => [
                    'username' => $this->connection->getClientKey(),
                    'password' => $this->connection->getSecretKey()
                ]
            ]
        );

        $this->connection->setCookie(
            current($response->getHeader('set-cookie'))
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
            'account/logout',
            ['query' => $this->getQuery()]
        );

        if (current($response)) {
            $this->connection->setCookie(null);
        }

        return (bool) current($response);
    }
}
