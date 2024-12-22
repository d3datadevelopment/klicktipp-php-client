<?php

namespace D3\KlicktippPhpClient\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class Subscriber extends ArrayCollection
{
    public const STATUS_SUBSCRIBED = 'subscribed';
    public const BOUNCE_NOTBOUNCED = 'Not Bounced';

    public function getId(): string
    {
        return $this->get('id') ?? '';
    }

    public function getListId(): string
    {
        return $this->get('listid') ?? '';
    }

    public function getOptinTime(): string
    {
        return $this->get('optin') ?? '';
    }

    public function getOptinIp(): string
    {
        return $this->get('optin_ip') ?? '';
    }

    public function getEmailAddress(): string
    {
        return $this->get('email') ?? '';
    }

    public function getStatus(): string
    {
        return $this->get('status') ?? '';
    }

    public function getBounce(): string
    {
        return $this->get('bounce') ?? '';
    }

    public function getDate(): string
    {
        return $this->get('date') ?? '';
    }

    public function getIp(): string
    {
        return $this->get('ip') ?? '';
    }

    public function getUnsubscription(): string
    {
        return $this->get('unsubscription') ?? '';
    }

    public function getUnsubscriptionIp(): string
    {
        return $this->get('unsubscription_ip') ?? '';
    }

    public function getReferrer(): string
    {
        return $this->get('referrer') ?? '';
    }

    public function getSmsPhone(): string
    {
        return $this->get('sms_phone') ?? '';
    }

    public function getSmsStatus(): string
    {
        return $this->get('sms_status') ?? '';
    }

    public function getSmsBounce(): string
    {
        return $this->get('sms_bounce') ?? '';
    }

    public function getSmsUnsubscription(): string
    {
        return $this->get('sms_unsubscription') ?? '';
    }

    public function getSmsReferrer(): string
    {
        return $this->get('sms_referrer') ?? '';
    }

    public function getField(string $fieldId): string
    {
        // ToDo: should we throw fieldNotSetException
        return $this->get('field'.trim($fieldId)) ?? '';
    }

    public function getTags(): array
    {
        return $this->get('tags') ?? [];
    }

    public function getManualTags(): array
    {
        return $this->get('manual_tags') ?? [];
    }

    public function getManualTag(string $tagId): string
    {
        return $this->getManualTags()[$tagId] ?? '';
    }

    public function getSmartTags(): array
    {
        return $this->get('smart_tags') ?? [];
    }

    public function getSmartTag(string $tagId): string
    {
        return $this->getSmartTags()[$tagId] ?? '';
    }

    public function getStartedCampaigns(): array
    {
        return $this->get('campaigns_started') ?? [];
    }

    public function getStartedCampaign(string $campaignId): string
    {
        return $this->getStartedCampaigns()[$campaignId] ?? '';
    }

    public function getFinishedCampaigns(): array
    {
        return $this->get('campaigns_finished') ?? [];
    }

    public function getFinishedCampaign(string $campaignId): string
    {
        return $this->getFinishedCampaigns()[$campaignId] ?? '';
    }

    public function getSentNotificationEmails(): array
    {
        return $this->get('notification_emails_sent') ?? [];
    }

    public function getOutbound(): array
    {
        return $this->get('outbound') ?? [];
    }

    public function getOpenedNotificationEmails(): array
    {
        return $this->get('notification_emails_opened') ?? [];
    }

    public function isSubscribed(): bool
    {
        return $this->getStatus() === self::STATUS_SUBSCRIBED;
    }

    public function isOptedIn(): bool
    {
        return $this->getOptinTime() != '0000-00-00 00:00:00' &&
            new DateTime($this->getOptinTime()) < new DateTime();
    }

    public function isBounced(): bool
    {
        return $this->getBounce() != self::BOUNCE_NOTBOUNCED;
    }

    public function isTagSet(string $tagId): bool
    {
        return in_array($tagId, $this->getTags());
    }
}