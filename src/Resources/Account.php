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

declare(strict_types=1);

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Entities\Account as AccountEntity;
use D3\KlicktippPhpClient\Exceptions\CommunicationException;
use D3\KlicktippPhpClient\Exceptions\ResponseContentException;
use GuzzleHttp\RequestOptions;

class Account extends Model
{
    public const UID = 'uid';
    public const STATUS = 'status';
    public const TIER = 'tier';
    public const USERGROUP = 'usergroup';
    public const EMAIL = 'email';
    public const FIRSTNAME = 'firstname';
    public const LASTNAME = 'lastname';
    public const COMPANY = 'company';
    public const WEBSITE = 'website';
    public const STREET = 'street';
    public const CITY = 'city';
    public const STATE = 'state';
    public const ZIP = 'zip';
    public const COUNTRY = 'country';
    public const PHONE = 'phone';
    public const FAX = 'fax';
    public const AFFILIATE_ID = 'affid';
    public const ACCESS_RIGHTS = 'access';
    public const SENDERS = 'senders';
    public const GMAIL_PREVIEW = 'gmailPreview';
    public const LIMITS = 'limits';
    public const PREFERENCES = 'preferences';
    public const SETTINGS = 'settings';
    public const SHOW_OTHER_ACCOUNT_INFO = 'showOtherAccountInfo';
    public const SHOW_SUPPORT_INFO = 'showSupportInfo';
    public const SUPPORT = 'support';
    public const LANGUAGE = 'language';
    public const SEGMENTS = 'segments';
    public const CUSTOMER_DATA = 'customerData';
    public const SUBSCRIPTION_INFO = 'subscriptionInfo';
    public const ACTIVE_PAYMENTS = 'activePayments';
    public const USERNAME = 'username';
    public const PASSWORD = 'password';

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function login(): array
    {
        return $this->connection->requestAndParse(
            'POST',
            'account/login.json',
            [
                RequestOptions::FORM_PARAMS => [
                    self::USERNAME => $this->connection->getClientKey(),
                    self::PASSWORD => $this->connection->getSecretKey(),
                ],
            ]
        );
    }

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function logout(): bool
    {
        $response = $this->connection->requestAndParse(
            'POST',
            'account/logout.json'
        );

        return (bool)current($response);
    }

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function get(): array
    {
        return $this->connection->requestAndParse(
            'GET',
            'account.json'
        );
    }

    /**
     * @throws CommunicationException
     */
    public function getEntity(): AccountEntity
    {
        return new AccountEntity($this->get(), $this);
    }

    /**
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function update(): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'GET',
                'account.json'
            )
        );
    }
}
