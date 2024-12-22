<?php

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Entities\Subscription as SubscriptionEntity;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class SubscriptionProcess extends Model
{
    /**
     * @throws BaseException|GuzzleException
     */
    public function index(): array
    {
        return $this->connection->requestAndParse(
            'GET',
            'list'
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function get(string $listId): SubscriptionEntity
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'list/'.urlencode(trim($listId))
        );

        return new SubscriptionEntity($data);
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function redirect(string $listId, string $email): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'list/redirect',
                [
                    RequestOptions::FORM_PARAMS => [
                        'listid'    => trim($listId),
                        'email'     => trim($email),
                    ]
                ]
            )
        );
    }
}
