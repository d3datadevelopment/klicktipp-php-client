<?php

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Entities\Subscriber as SubscriberEntity;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\Exception\GuzzleException;

class Subscriber extends Model
{
    /**
     * @throws BaseException|GuzzleException
     */
    public function index(): array
    {
        return $this->connection->requestAndParse(
            'GET',
            'subscriber',
            [
                'query' => $this->getQuery()
            ]
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function get(string $subscriberId): SubscriberEntity
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'subscriber/'.urlencode(trim($subscriberId)),
            [
                'query' => $this->getQuery()
            ]
        );

        return new SubscriberEntity($data);
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function search(string $mailAddress): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/search',
                [
                    'query' => $this->getQuery(),
                    'form_params' => [
                        'email' => trim($mailAddress)
                    ]
                ]
            )
        );
    }
}
