<?php

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Entities\Subscriber as SubscriberEntity;
use D3\KlicktippPhpClient\Entities\SubscriberList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Subscriber extends Model
{
    /**
     * @throws BaseException|GuzzleException
     */
    public function index(): SubscriberList
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'subscriber'
        );

        return new SubscriberList($data);
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
    public function tag(string $mailAddress, array $tagIds): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/tag',
                [
                    RequestOptions::FORM_PARAMS => [
                        'email' => trim($mailAddress),
                        //ToDo: apply trim to array
                        'tagids' => $tagIds
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

    /**
     * @throws BaseException|GuzzleException
     */
    public function tagged(string $tagId): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/tagged',
                [
                    RequestOptions::FORM_PARAMS => [
                        'tagid' => trim($tagId)
                    ]
                ]
            )
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function update(string $subscriberId, array $fields, string $newEmail = '', string $newSmsNumber = ''): string
    {
        return current(
            $this->connection->requestAndParse(
                'PUT',
                'subscriber/'.urlencode(trim($subscriberId)),
                [
                    RequestOptions::FORM_PARAMS => [
                        //ToDo: apply trim to array
                        'fields' => $fields,
                        'newemail' => trim($newEmail),
                        'newsmsnumber' => trim($newSmsNumber),
                    ]
                ]
            )
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function delete(string $subscriberId): string
    {
        return current(
            $this->connection->requestAndParse(
                'DELETE',
                'subscriber/'.urlencode(trim($subscriberId))
            )
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function signin(string $apikey, string $emailAddress, array $fields, string $smsNumber): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/signin',
                [
                    RequestOptions::FORM_PARAMS => [
                        'apikey' => trim($apikey),
                        'email' => trim($emailAddress),
                        //ToDo: apply trim to array
                        'fields' => $fields,
                        'smsnumber' => trim($smsNumber),
                    ]
                ]
            )
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function signout(string $apikey, string $emailAddress): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/signout',
                [
                    RequestOptions::FORM_PARAMS => [
                        'apikey' => trim($apikey),
                        'email' => trim($emailAddress),
                    ]
                ]
            )
        );
    }

    /**
     * @throws BaseException|GuzzleException
     */
    public function signoff(string $apikey, string $emailAddress): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/signoff',
                [
                    RequestOptions::FORM_PARAMS => [
                        'apikey' => trim($apikey),
                        'email' => trim($emailAddress),
                    ]
                ]
            )
        );
    }
}
