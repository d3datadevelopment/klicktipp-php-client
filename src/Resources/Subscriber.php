<?php

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Entities\Subscriber as SubscriberEntity;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Subscriber extends Model
{
    /**
     * @throws BaseException|GuzzleException
     */
    public function index(): array
    {
        return $this->connection->requestAndParse(
            'GET',
            'subscriber'
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function get(string $subscriberId): SubscriberEntity
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'subscriber/'.urlencode(trim($subscriberId))
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
                    RequestOptions::FORM_PARAMS => [
                        'email' => trim($mailAddress)
                    ]
                ]
            )
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function subscribe(
        string $mailAddress,
        string $listId,
        string $tagId,
        array $fields,
        string $smsNumber
    ): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber',
                [
                    RequestOptions::FORM_PARAMS => [
                        'email' => trim($mailAddress),
                        'listid' => trim($listId),
                        'tagid' => trim($tagId),
                        'fields' => array_filter($fields),
                        'smsnumber' => trim($smsNumber),
                    ]
                ]
            )
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function unsubscribe(string $mailAddress): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/unsubscribe',
                [
                    RequestOptions::FORM_PARAMS => [
                        'email' => trim($mailAddress)
                    ]
                ]
            )
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function tag(string $mailAddress, string $tagId): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/tag',
                [
                    RequestOptions::FORM_PARAMS => [
                        'email' => trim($mailAddress),
                        'tagid' => trim($tagId)
                    ]
                ]
            )
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function untag(string $mailAddress, string $tagId): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/search',
                [
                    RequestOptions::FORM_PARAMS => [
                        'email' => trim($mailAddress),
                        'tagid' => trim($tagId)
                    ]
                ]
            )
        );
    }
}
