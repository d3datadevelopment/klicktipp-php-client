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
use D3\KlicktippPhpClient\Exceptions\InvalidCredentialTypeException;
use D3\KlicktippPhpClient\Resources\Account as AccountEndpoint;
use Doctrine\Common\Collections\ArrayCollection;

class Account extends Entity
{
    private ?AccountEndpoint $endpoint;

    public function __construct(array $elements = [], ?AccountEndpoint $endpoint = null)
    {
        $this->endpoint = $endpoint;
        parent::__construct($elements);
    }

    /**
     * @throws InvalidCredentialTypeException
     */
    public function getId(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::UID));
    }

    public function getStatus(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::STATUS));
    }

    public function getTier(): ?int
    {
        return $this->getIntOrNullValue($this->get(AccountEndpoint::TIER));
    }

    public function getUsergroup(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::USERGROUP));
    }

    public function getEmail(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::EMAIL));
    }

    public function getFirstname(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::FIRSTNAME));
    }

    public function getLastname(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::LASTNAME));
    }

    public function getCompany(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::COMPANY));
    }

    public function getWebsite(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::WEBSITE));
    }

    public function getStreet(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::STREET));
    }

    public function getCity(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::CITY));
    }

    public function getState(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::STATE));
    }

    public function getZIP(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::ZIP));
    }

    public function getCountry(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::COUNTRY));
    }

    public function getPhone(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::PHONE));
    }

    public function getFax(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::FAX));
    }

    public function getAffiliateId(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::AFFILIATE_ID));
    }

    public function getAccessRights(): ?ArrayCollection
    {
        return $this->getArrayCollectionFromValue($this->get(AccountEndpoint::ACCESS_RIGHTS));
    }

    public function getSenders(): ?ArrayCollection
    {
        return $this->getArrayCollectionFromValue($this->get(AccountEndpoint::SENDERS));
    }

    public function getGmailPreview(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::GMAIL_PREVIEW));
    }

    public function getLimits(): ?ArrayCollection
    {
        return $this->getArrayCollectionFromValue($this->get(AccountEndpoint::LIMITS));
    }

    public function getPreferences(): ?ArrayCollection
    {
        return $this->getArrayCollectionFromValue($this->get(AccountEndpoint::PREFERENCES));
    }

    public function getSettings(): ?ArrayCollection
    {
        return $this->getArrayCollectionFromValue($this->get(AccountEndpoint::SETTINGS));
    }

    public function canShowOtherAccountInfo(): ?bool
    {
        return $this->getBooleanOrNullValue($this->get(AccountEndpoint::SHOW_OTHER_ACCOUNT_INFO));
    }

    public function canShowSupportInfo(): ?bool
    {
        return $this->getBooleanOrNullValue($this->get(AccountEndpoint::SHOW_SUPPORT_INFO));
    }

    public function getSupport(): ?ArrayCollection
    {
        return $this->getArrayCollectionFromValue($this->get(AccountEndpoint::SUPPORT));
    }

    public function getLanguage(): ?string
    {
        return $this->getStringOrNullValue($this->get(AccountEndpoint::LANGUAGE));
    }

    public function getSegments(): ?ArrayCollection
    {
        return $this->getArrayCollectionFromValue($this->get(AccountEndpoint::SEGMENTS));
    }

    public function getCustomerData(): ?ArrayCollection
    {
        return $this->getArrayCollectionFromValue($this->get(AccountEndpoint::CUSTOMER_DATA));
    }

    public function getSubscriptionInfo(): ?ArrayCollection
    {
        return $this->getArrayCollectionFromValue($this->get(AccountEndpoint::SUBSCRIPTION_INFO));
    }

    public function getActivePayments(): ?ArrayCollection
    {
        return $this->getArrayCollectionFromValue($this->get(AccountEndpoint::ACTIVE_PAYMENTS));
    }

    /**
     * @return null|bool
     * @throws BaseException
     */
    public function persist(): ?bool
    {
        return $this->endpoint?->update();
    }
}
