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

use D3\KlicktippPhpClient\Entities\Subscription as SubscriptionEntity;
use D3\KlicktippPhpClient\Entities\SubscriptionList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\RequestOptions;

class SubscriptionProcess extends Model
{
    public const LISTID = 'listid';
    public const NAME = 'name';
    public const PENDINGURL = 'pendingurl';
    public const THANKYOUURL = 'thankyouurl';
    public const USE_SINGLE_OPTIN = 'usesingleoptin';
    public const RESEND_CONFIRMATION_EMAIL = 'resendconfirmationemail';
    public const USE_CHANGE_EMAIL = 'usechangeemail';
    public const PARAM_EMAIL = 'email';

    /**
     * @throws BaseException
     */
    public function index(): SubscriptionList
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'list.json'
        );

        return new SubscriptionList($data);
    }

    /**
     * @throws BaseException
     */
    public function get(string $listId): SubscriptionEntity
    {
        $data = $this->connection->requestAndParse(
            'GET',
            'list/'.urlencode(trim($listId)).'.json'
        );

        return new SubscriptionEntity($data);
    }

    /**
     * @throws BaseException
     */
    public function create(?string $name): SubscriptionEntity
    {
        $data = $this->connection->requestAndParse(
            'POST',
            'list.json',
            [
                RequestOptions::FORM_PARAMS => array_filter([
                    self::NAME => trim($name ?? ''),
                ]),
            ]
        );

        return new SubscriptionEntity($data);
    }

    /**
     * @throws BaseException
     */
    public function update(string $listId, ?string $name): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'PUT',
                'list/'.urlencode(trim($listId)).'.json',
                [
                    RequestOptions::FORM_PARAMS => array_filter([
                        self::NAME => trim($name ?? ''),
                    ]),
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function redirect(string $listId, string $email): string
    {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'list/redirect.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        self::LISTID        => trim($listId),
                        self::PARAM_EMAIL   => trim($email),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function delete(string $listId): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'DELETE',
                'list/'.urlencode(trim($listId)).'.json'
            )
        );
    }
}
