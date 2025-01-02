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

namespace D3\KlicktippPhpClient\Entities;

use D3\KlicktippPhpClient\Exceptions\BaseException;
use D3\KlicktippPhpClient\Resources\Subscriber as SubscriberEndpoint;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class Subscriber extends ArrayCollection
{
    public const STATUS_SUBSCRIBED = 'subscribed';
    public const BOUNCE_NOTBOUNCED = 'Not Bounced';

    private ?SubscriberEndpoint $endpoint;

    public function __construct(array $elements = [], ?SubscriberEndpoint $endpoint = null)
    {
        $this->endpoint = $endpoint;
        parent::__construct($elements);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function getListId(): ?string
    {
        return $this->get('listid');
    }

    public function getOptinTime(): ?DateTime
    {
        return $this->getDateTimeFromValue($this->get('optin'));
    }

    public function isOptedIn(): bool
    {
        return $this->getOptinTime() !== null &&
            $this->getOptinTime() > new DateTime('0000-00-00 00:00:00') &&
            $this->getOptinTime() < new DateTime();
    }

    public function getOptinIp(): ?string
    {
        return $this->get('optin_ip');
    }

    public function getEmailAddress(): ?string
    {
        return $this->get('email');
    }

    public function changeEmailAddress(string $emailAddress): void
    {
        $this->set('email', $emailAddress);

        // use persist method to send to Klicktipp
    }

    public function getStatus(): ?string
    {
        return $this->get('status');
    }

    public function isSubscribed(): bool
    {
        return $this->getStatus() === self::STATUS_SUBSCRIBED;
    }

    public function getBounce(): ?string
    {
        return $this->get('bounce');
    }

    public function isBounced(): bool
    {
        return $this->getBounce() !== self::BOUNCE_NOTBOUNCED;
    }

    public function getDate(): ?DateTime
    {
        return $this->getDateTimeFromValue($this->get('date'));
    }

    public function getIp(): ?string
    {
        return $this->get('ip');
    }

    public function getUnsubscription(): ?DateTime
    {
        return $this->getDateTimeFromValue($this->get('unsubscription'));
    }

    public function getUnsubscriptionIp(): ?string
    {
        return $this->get('unsubscription_ip');
    }

    public function getReferrer(): ?string
    {
        return $this->get('referrer');
    }

    public function getSmsPhone(): ?string
    {
        return $this->get('sms_phone');
    }

    public function setSmsPhone(string $smsPhone): void
    {
        $this->set('sms_phone', $smsPhone);

        // use persist method to send to Klicktipp
    }

    public function getSmsStatus(): ?string
    {
        return $this->get('sms_status');
    }

    public function getSmsBounce(): ?string
    {
        return $this->get('sms_bounce');
    }

    public function getSmsDate(): ?DateTime
    {
        return $this->getDateTimeFromValue($this->get('sms_date'));
    }

    public function getSmsUnsubscription(): ?string
    {
        return $this->getDateTimeFromValue($this->get('sms_unsubscription'));
    }

    public function getSmsReferrer(): ?string
    {
        return $this->get('sms_referrer');
    }

    public function getFields(): ArrayCollection
    {
        return $this->filter(
            function ($value, $key) {
                return str_starts_with($key, 'field');
            }
        );
    }

    public function getField(string $fieldId): ?string
    {
        return $this->getFields()->get($this->getFieldLongName($fieldId));
    }

    public function setField(string $fieldId, string $value): void
    {
        $this->set($this->getFieldLongName($fieldId), $value);

        // use persist method to send to Klicktipp
    }

    protected function getFieldLongName(string $fieldId): ?string
    {
        return str_starts_with($fieldId, 'field') ? trim($fieldId) : 'field'.trim($fieldId);
    }

    public function getTags(): ArrayCollection
    {
        return new ArrayCollection($this->get('tags') ?? []);
    }

    public function isTagSet(string $tagId): bool
    {
        return $this->getTags()->contains($tagId);
    }

    public function clearTags(): void
    {
        $tags = $this->getTags();
        $tags->clear();
        $this->set('tags', $tags->toArray());

        // use persist method to send to Klicktipp
    }

    public function addTag(string $tagId): void
    {
        $tags = $this->getTags();
        $tags->add($tagId);
        $this->set('tags', $tags->toArray());

        // use persist method to send to Klicktipp
    }

    public function removeTag(string $tagId): void
    {
        $tags = $this->getTags();
        $tags->removeElement($tagId);
        $this->set('tags', $tags->toArray());

        // use persist method to send to Klicktipp
    }

    /**
     * manuelle Tags
     */
    public function getManualTags(): ArrayCollection
    {
        return new ArrayCollection($this->get('manual_tags') ?? []);
    }

    public function isManualTagSet(string $tagId): bool
    {
        return $this->getManualTags()->containsKey($tagId);
    }

    public function getManualTagTime(string $tagId): ?DateTime
    {
        return $this->getDateTimeFromValue($this->getManualTags()->get($tagId));
    }

    public function getSmartTags(): ArrayCollection
    {
        return new ArrayCollection($this->get('smart_tags') ?? []);
    }

    public function getSmartTagTime(string $tagId): ?DateTime
    {
        return $this->getDateTimeFromValue($this->getSmartTags()->get($tagId));
    }

    /**
     * Kampagne gestartet
     */
    public function getStartedCampaigns(): ArrayCollection
    {
        return new ArrayCollection($this->get('campaigns_started') ?? []);
    }

    public function getStartedCampaignTime(string $campaignId): ?DateTime
    {
        return $this->getDateTimeFromValue($this->getStartedCampaigns()->get($campaignId));
    }

    /**
     * Kampagne beendet
     */
    public function getFinishedCampaigns(): ArrayCollection
    {
        return new ArrayCollection($this->get('campaigns_finished') ?? []);
    }

    public function getFinishedCampaignTime(string $campaignId): ?DateTime
    {
        return $this->getDateTimeFromValue($this->getFinishedCampaigns()->get($campaignId));
    }

    /**
     * Email (Marketing Cockpit) erhalten
     */
    public function getSentNotificationEmails(): ArrayCollection
    {
        return new ArrayCollection($this->get('notification_emails_sent') ?? []);
    }

    /**
     * Email (Marketing Cockpit) geoeffnet
     */
    public function getOpenedNotificationEmails(): ArrayCollection
    {
        return new ArrayCollection($this->get('notification_emails_opened') ?? []);
    }

    /**
     * Email (Marketing Cockpit) geklickt
     */
    public function getClickedNotificationEmails(): ArrayCollection
    {
        return new ArrayCollection($this->get('notification_emails_clicked') ?? []);
    }

    /**
     * Email (Marketing Cockpit) im Webbrowser angesehen
     */
    public function getViewedNotificationEmails(): ArrayCollection
    {
        return new ArrayCollection($this->get('notification_emails_viewed') ?? []);
    }

    /**
     * Outbound ausgeloest
     */
    public function getOutbounds(): ArrayCollection
    {
        return new ArrayCollection($this->get('outbound') ?? []);
    }

    /**
     * @return null|bool
     * @throws BaseException
     */
    public function persist(): ?bool
    {
        $return = $this->endpoint?->update(
            $this->getId(),
            $this->getFields()->toArray(),
            $this->getEmailAddress(),
            $this->getSmsPhone()
        );

        $this->persistTags();

        return $return;
    }

    /**
     * @throws BaseException
     */
    protected function persistTags(): void
    {
        if (!$this->endpoint instanceof SubscriberEndpoint) {
            return;
        }

        $currentTags = $this->endpoint->get($this->getId())->getTags();

        $removeTags = array_diff($currentTags->toArray(), $this->getTags()->toArray());
        if (count($removeTags)) {
            foreach ($removeTags as $removeTag) {
                $this->endpoint->untag($this->getEmailAddress(), $removeTag);
            }
        }

        $addTags = array_diff($this->getTags()->toArray(), $currentTags->toArray());
        if (count($addTags)) {
            $this->endpoint->tag($this->getEmailAddress(), $addTags);
        }
    }

    protected function getDateTimeFromValue($value): ?DateTime
    {
        try {
            return $value ?
                new DateTime((string)$value) :
                null;
        } catch (Exception) {
            return null;
        }
    }

    // missing getters (return is timestamp list)

    // smart_links  SmartLinks
    // emails_sent  Newsletter / Autoresponder erhalten
    // emails_opened    Newsletter / Autoresponder geoeffnet
    // emails_clicked   Newsletter / Autoresponder geklickt
    // emails_viewed    Newsletter / Autoresponder im Webbrowser angesehen
    // conversions      Newsletter / Autoresponder Conversion-Pixel geladen
    // kajabi_activated Kajabi Membership aktiviert
    // kajabi_deactivated   Kajabi Membership deaktiviert
    // taggingpixel_triggered   Tagging-Pixel ausgeloest
    // notification_sms_sent    SMS (Marketing Cockpit) erhalten
    // notification_sms_clicked SMS (Marketing Cockpit) geklickt
    // api_subscriptions    Via API-Key eingetragen
    // email_subscriptions  Via E-Mail eingetragen
    // sms_subscriptions    Via SMS eingetragen
    // form_subscriptions   Via Anmeldeformular
    // facebook_subscriptions   Via Facebook-Button eingetragen
    // payments     Zahlung eingegangen
    // refunds      Rueckzahlung ausgeloest
    // chargebacks  Chargeback ausgeloest
    // rebills_canceled     Abo gekuendigt
    // rebills_resumed      Abo wiederaufgenommen
    // rebills_expired      Letzten Tag des Abo erreicht
    // digistore_affiliations   Affiliate eines Digistore24-Produkts
}
