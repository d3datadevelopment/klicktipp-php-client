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

use D3\KlicktippPhpClient\Entities\Subscriber as SubscriberEntity;
use D3\KlicktippPhpClient\Entities\SubscriberList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Subscriber extends Model
{
    /**
     * @throws BaseException
     */
    public function index(): SubscriberList
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'subscriber.json'
        );

        return new SubscriberList($data);
    }

    /**
     * @throws BaseException
     */
    public function get(string $subscriberId): SubscriberEntity
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'subscriber/'.urlencode(trim($subscriberId)).'.json'
        );

        return new SubscriberEntity($data);
    }

    /**
     * @throws BaseException
     */
    public function search(string $mailAddress): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/search.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        'email' => trim($mailAddress),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function subscribe(
        string $mailAddress,
        ?string $listId = null,
        ?string $tagId = null,
        ?array $fields = null,
        ?string $smsNumber = null,
    ): string {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber.json',
                [
                    RequestOptions::FORM_PARAMS => array_filter(
                        [
                            'email' => trim($mailAddress),
                            'listid' => trim($listId ?? ''),
                            'tagid' => trim($tagId ?? ''),
                            'fields' => array_filter($fields ?? []),
                            'smsnumber' => trim($smsNumber ?? ''),
                        ]
                    ),
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function unsubscribe(string $mailAddress): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/unsubscribe.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        'email' => trim($mailAddress),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function tag(string $mailAddress, array $tagIds): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/tag.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        'email' => trim($mailAddress),
                        'tagids' => implode(',', array_filter(
                            array_map('trim', $tagIds)
                        )),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function untag(string $mailAddress, string $tagId): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/untag.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        'email' => trim($mailAddress),
                        'tagid' => trim($tagId),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function tagged(string $tagId): array
    {
        return $this->connection->requestAndParse(
            'POST',
            'subscriber/tagged.json',
            [
                RequestOptions::FORM_PARAMS => [
                    'tagid' => trim($tagId),
                ],
            ]
        ) ?? [];
    }

    /**
     * @throws BaseException
     */
    public function update(
        string $subscriberId,
        array $fields,
        string $newEmail = '',
        string $newSmsNumber = ''
    ): string {
        return current(
            $this->connection->requestAndParse(
                'PUT',
                'subscriber/'.urlencode(trim($subscriberId)).'.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        //ToDo: apply trim to array
                        'fields' => array_filter(array_map('trim', $fields)),
                        'newemail' => trim($newEmail),
                        'newsmsnumber' => trim($newSmsNumber),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function delete(string $subscriberId): string
    {
        return current(
            $this->connection->requestAndParse(
                'DELETE',
                'subscriber/'.urlencode(trim($subscriberId)).'.json'
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function signin(string $apikey, string $emailAddress, array $fields, string $smsNumber): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/signin.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        'apikey' => trim($apikey),
                        'email' => trim($emailAddress),
                        //ToDo: apply trim to array
                        'fields' => $fields,
                        'smsnumber' => trim($smsNumber),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function signout(string $apikey, string $emailAddress): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/signout.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        'apikey' => trim($apikey),
                        'email' => trim($emailAddress),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function signoff(string $apikey, string $emailAddress): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/signoff.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        'apikey' => trim($apikey),
                        'email' => trim($emailAddress),
                    ],
                ]
            )
        );
    }
}
