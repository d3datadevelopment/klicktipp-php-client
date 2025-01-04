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
use GuzzleHttp\RequestOptions;

class Subscriber extends Model
{
    public const ID = 'id';
    public const LISTID = 'listid';
    public const OPTIN = 'optin';
    public const OPTIN_IP = 'optin_ip';
    public const EMAIL = 'email';
    public const STATUS = 'status';
    public const BOUNCE = 'bounce';
    public const IP = 'ip';
    public const UNSUBSCRIPTION = 'unsubscription';
    public const UNSUBSCRIPTION_IP = 'unsubscription_ip';
    public const SMS_PHONE = 'sms_phone';
    public const SMS_STATUS = 'sms_status';
    public const SMS_BOUNCE = 'sms_bounce';
    public const SMS_DATE = 'sms_date';
    public const SMS_UNSUBSCRIPTION = 'sms_unsubscription';
    public const SMS_REFERRER = 'sms_referrer';
    public const REFERRER = 'referrer';
    public const DATE = 'date';
    public const FIELD_FIRSTNAME = 'fieldFirstName';
    public const FIELD_LASTNAME  = 'fieldLastName';
    public const FIELD_COMPANYNAME  = 'fieldCompanyName';
    public const FIELD_STREET1  = 'fieldStreet1';
    public const FIELD_STREET2  = 'fieldStreet2';
    public const FIELD_CITY  = 'fieldCity';
    public const FIELD_STATE  = 'fieldState';
    public const FIELD_ZIP  = 'fieldZip';
    public const FIELD_COUNTRY  = 'fieldCountry';
    public const FIELD_PRIVATEPHONE  = 'fieldPrivatePhone';
    public const FIELD_MOBILEPHONE  = 'fieldMobilePhone';
    public const FIELD_PHONE  = 'fieldPhone';
    public const FIELD_FAX  = 'fieldFax';
    public const FIELD_WEBSITE  = 'fieldWebsite';
    public const FIELD_BIRTHDAY  = 'fieldBirthday';
    public const FIELD_LEADVALUE  = 'fieldLeadValue';
    public const TAGS  = 'tags';
    public const MANUALTAGS  = 'manual_tags';
    public const SMARTTAGS  = 'smart_tags';
    public const CAMPAIGNSSTARTED  = 'campaigns_started';
    public const CAMPAIGNSFINISHED  = 'campaigns_finished';
    public const NOTIFICATIONEMAILSSENT  = 'notification_emails_sent';
    public const NOTIFICATIONEMAILSOPENED  = 'notification_emails_opened';
    public const NOTIFICATIONEMAILSCLICKED  = 'notification_emails_clicked';
    public const NOTIFICATIONEMAILSVIEWED  = 'notification_emails_viewed';
    public const OUTBOUND  = 'outbound';
    public const PARAM_TAGID  = 'tagid';
    public const PARAM_TAGIDS  = 'tagids';
    public const PARAM_FIELDS  = 'fields';
    public const PARAM_SMS_NUMBER  = 'smsnumber';
    public const PARAM_NEW_EMAIL  = 'newemail';
    public const PARAM_NEW_SMSNUMBER  = 'newsmsnumber';
    public const PARAM_APIKEY  = 'apikey';

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
    public function get(string $subscriberId): array
    {
        return $this->connection->requestAndParse(
            'GET',
            'subscriber/'.urlencode(trim($subscriberId)).'.json'
        );
    }

    /**
     * @throws BaseException
     */
    public function getEntity(string $subscriberId): SubscriberEntity
    {
        return new SubscriberEntity($this->get($subscriberId), $this);
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
                        self::EMAIL => trim($mailAddress),
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
                            self::EMAIL => trim($mailAddress),
                            self::LISTID => trim($listId ?? ''),
                            self::PARAM_TAGID => trim($tagId ?? ''),
                            self::PARAM_FIELDS => array_filter(
                                array_map('trim', $fields ?? [])
                            ),
                            self::PARAM_SMS_NUMBER => trim($smsNumber ?? ''),
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
                        self::EMAIL => trim($mailAddress),
                    ],
                ]
            )
        );
    }

    /**
     * add tag
     * @throws BaseException
     */
    public function tag(string $mailAddress, array $tagIds): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/tag.json',
                [
                    RequestOptions::FORM_PARAMS => array_filter(
                        [
                            self::EMAIL => trim($mailAddress),
                            self::PARAM_TAGIDS => array_filter(
                                array_map('trim', $tagIds)
                            ),
                        ]
                    ),
                ]
            )
        );
    }

    /**
     * remove tag
     * @throws BaseException
     */
    public function untag(string $mailAddress, string $tagId): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/untag.json',
                [
                    RequestOptions::FORM_PARAMS => [
                        self::EMAIL => trim($mailAddress),
                        self::PARAM_TAGID => trim($tagId),
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
                    self::PARAM_TAGID => trim($tagId),
                ],
            ]
        ) ?? [];
    }

    /**
     * @throws BaseException
     */
    public function update(
        string $subscriberId,
        ?array $fields = null,
        ?string $newEmail = null,
        ?string $newSmsNumber = null
    ): bool {
        return (bool) current(
            $this->connection->requestAndParse(
                'PUT',
                'subscriber/'.urlencode(trim($subscriberId)).'.json',
                [
                    RequestOptions::FORM_PARAMS => array_filter(
                        [
                            self::PARAM_NEW_EMAIL => trim($newEmail ?? ''),
                            self::PARAM_NEW_SMSNUMBER => trim($newSmsNumber ?? ''),
                            self::PARAM_FIELDS => array_filter(
                                array_map('trim', $fields ?? [])
                            ),
                        ]
                    ),
                ]
            )
        );
    }

    /**
     * @throws BaseException
     * @return true
     */
    public function delete(string $subscriberId): bool
    {
        return (bool) current(
            $this->connection->requestAndParse(
                'DELETE',
                'subscriber/'.urlencode(trim($subscriberId)).'.json'
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function signin(
        string $apikey,
        string $emailAddress,
        ?array $fields = null,
        ?string $smsNumber = null
    ): string {
        return current(
            $this->connection->requestAndParse(
                'POST',
                'subscriber/signin.json',
                [
                    RequestOptions::FORM_PARAMS => array_filter(
                        [
                            self::PARAM_APIKEY => trim($apikey),
                            self::EMAIL => trim($emailAddress),
                            self::PARAM_SMS_NUMBER => trim($smsNumber ?? ''),
                            self::PARAM_FIELDS => array_filter(
                                array_map('trim', $fields ?? [])
                            ),
                        ]
                    ),
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
                        self::PARAM_APIKEY => trim($apikey),
                        self::EMAIL => trim($emailAddress),
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
                        self::PARAM_APIKEY => trim($apikey),
                        self::EMAIL => trim($emailAddress),
                    ],
                ]
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function setSubscriber(
        string $mailAddress,
        ?string $newMailAddress = null,
        ?string $smsNumber = null,
        ?array $fields = null
    ): SubscriberEntity {
        try {
            $id = $this->search($mailAddress);
            $this->update($id, $fields, $newMailAddress ?? $mailAddress, $smsNumber);
        } catch (BaseException) {
            $id = $this->subscribe($newMailAddress ?? $mailAddress, null, null, $fields, $smsNumber);
        }

        return $this->getEntity($id);
    }

    /**
     * @throws BaseException
     */
    public function getSubscriberByMailAddress(string $mailAddress): SubscriberEntity
    {
        return $this->getEntity(
            $this->search($mailAddress)
        );
    }
}
