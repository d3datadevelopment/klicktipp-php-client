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
        return $this->get(SubscriberEndpoint::ID);
    }

    public function getListId(): ?string
    {
        return $this->get(SubscriberEndpoint::LISTID);
    }

    public function getOptinTime(): ?DateTime
    {
        return $this->getDateTimeFromValue($this->get(SubscriberEndpoint::OPTIN));
    }

    public function isOptedIn(): bool
    {
        return $this->getOptinTime() !== null &&
            $this->getOptinTime() > new DateTime('0000-00-00 00:00:00') &&
            $this->getOptinTime() < new DateTime();
    }

    public function getOptinIp(): ?string
    {
        return $this->get(SubscriberEndpoint::OPTIN_IP);
    }

    public function getEmailAddress(): ?string
    {
        return $this->get(SubscriberEndpoint::EMAIL);
    }

    public function changeEmailAddress(string $emailAddress): void
    {
        $this->set(SubscriberEndpoint::EMAIL, $emailAddress);

        // use persist method to send to Klicktipp
    }

    public function getStatus(): ?string
    {
        return $this->get(SubscriberEndpoint::STATUS);
    }

    public function isSubscribed(): bool
    {
        return $this->getStatus() === self::STATUS_SUBSCRIBED;
    }

    public function getBounce(): ?string
    {
        return $this->get(SubscriberEndpoint::BOUNCE);
    }

    public function isBounced(): bool
    {
        return $this->getBounce() !== self::BOUNCE_NOTBOUNCED;
    }

    public function getDate(): ?DateTime
    {
        return $this->getDateTimeFromValue($this->get(SubscriberEndpoint::DATE));
    }

    public function getIp(): ?string
    {
        return $this->get(SubscriberEndpoint::IP);
    }

    public function getUnsubscription(): ?DateTime
    {
        return $this->getDateTimeFromValue($this->get(SubscriberEndpoint::UNSUBSCRIPTION));
    }

    public function getUnsubscriptionIp(): ?string
    {
        return $this->get(SubscriberEndpoint::UNSUBSCRIPTION_IP);
    }

    public function getReferrer(): ?string
    {
        return $this->get(SubscriberEndpoint::REFERRER);
    }

    public function getSmsPhone(): ?string
    {
        return $this->get(SubscriberEndpoint::SMS_PHONE);
    }

    public function setSmsPhone(string $smsPhone): void
    {
        $this->set(SubscriberEndpoint::SMS_PHONE, $smsPhone);

        // use persist method to send to Klicktipp
    }

    public function getSmsStatus(): ?string
    {
        return $this->get(SubscriberEndpoint::SMS_STATUS);
    }

    public function getSmsBounce(): ?string
    {
        return $this->get(SubscriberEndpoint::SMS_BOUNCE);
    }

    public function getSmsDate(): ?DateTime
    {
        return $this->getDateTimeFromValue($this->get(SubscriberEndpoint::SMS_DATE));
    }

    public function getSmsUnsubscription(): ?string
    {
        return $this->getDateTimeFromValue($this->get(SubscriberEndpoint::SMS_UNSUBSCRIPTION));
    }

    public function getSmsReferrer(): ?string
    {
        return $this->get(SubscriberEndpoint::SMS_REFERRER);
    }

    public function getFields(): ArrayCollection
    {
        return $this->filter(
            fn ($value, $key) => str_starts_with($key, 'field')
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
        return new ArrayCollection($this->get(SubscriberEndpoint::TAGS) ?? []);
    }

    public function isTagSet(string $tagId): bool
    {
        return $this->getTags()->contains($tagId);
    }

    public function clearTags(): void
    {
        $tags = $this->getTags();
        $tags->clear();
        $this->set(SubscriberEndpoint::TAGS, $tags->toArray());

        // use persist method to send to Klicktipp
    }

    public function addTag(string $tagId): void
    {
        $tags = $this->getTags();
        $tags->add($tagId);
        $this->set(SubscriberEndpoint::TAGS, $tags->toArray());

        // use persist method to send to Klicktipp
    }

    public function removeTag(string $tagId): void
    {
        $tags = $this->getTags();
        $tags->removeElement($tagId);
        $this->set(SubscriberEndpoint::TAGS, $tags->toArray());

        // use persist method to send to Klicktipp
    }

    /**
     * manuelle Tags
     */
    public function getManualTags(): ArrayCollection
    {
        return new ArrayCollection($this->get(SubscriberEndpoint::MANUALTAGS) ?? []);
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
        return new ArrayCollection($this->get(SubscriberEndpoint::SMARTTAGS) ?? []);
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
        return new ArrayCollection($this->get(SubscriberEndpoint::CAMPAIGNSSTARTED) ?? []);
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
        return new ArrayCollection($this->get(SubscriberEndpoint::CAMPAIGNSFINISHED) ?? []);
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
        return new ArrayCollection($this->get(SubscriberEndpoint::NOTIFICATIONEMAILSSENT) ?? []);
    }

    /**
     * Email (Marketing Cockpit) geoeffnet
     */
    public function getOpenedNotificationEmails(): ArrayCollection
    {
        return new ArrayCollection($this->get(SubscriberEndpoint::NOTIFICATIONEMAILSOPENED) ?? []);
    }

    /**
     * Email (Marketing Cockpit) geklickt
     */
    public function getClickedNotificationEmails(): ArrayCollection
    {
        return new ArrayCollection($this->get(SubscriberEndpoint::NOTIFICATIONEMAILSCLICKED) ?? []);
    }

    /**
     * Email (Marketing Cockpit) im Webbrowser angesehen
     */
    public function getViewedNotificationEmails(): ArrayCollection
    {
        return new ArrayCollection($this->get(SubscriberEndpoint::NOTIFICATIONEMAILSVIEWED) ?? []);
    }

    /**
     * Outbound ausgeloest
     */
    public function getOutbounds(): ArrayCollection
    {
        return new ArrayCollection($this->get(SubscriberEndpoint::OUTBOUND) ?? []);
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

        $currentTags = $this->endpoint->getEntity($this->getId())->getTags();

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
