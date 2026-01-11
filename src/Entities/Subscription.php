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

use Assert\Assert;
use D3\KlicktippPhpClient\Exceptions\CommunicationException;
use D3\KlicktippPhpClient\Exceptions\MissingEndpointException;
use D3\KlicktippPhpClient\Resources\SubscriptionProcess;

class Subscription extends Entity
{
    private ?SubscriptionProcess $endpoint;

    public function __construct(array $elements = [], ?SubscriptionProcess $endpoint = null)
    {
        $this->endpoint = $endpoint;
        parent::__construct($elements);
    }

    private function getEndpoint(): SubscriptionProcess
    {
        Assert::lazy()
            ->setExceptionClass(MissingEndpointException::class)
            ->that($this->endpoint)
            ->isInstanceOf(SubscriptionProcess::class)
            ->verifyNow();

        return $this->endpoint;
    }

    public function getListId(): ?string
    {
        return $this->getStringOrNullValue($this->get(SubscriptionProcess::LISTID));
    }

    public function getName(): ?string
    {
        return $this->getStringOrNullValue($this->get(SubscriptionProcess::NAME));
    }

    public function setName(string $name): void
    {
        $this->set(SubscriptionProcess::NAME, $name);
    }

    public function getPendingUrl(): ?string
    {
        return $this->getStringOrNullValue($this->get(SubscriptionProcess::PENDINGURL));
    }

    public function getThankyouUrl(): ?string
    {
        return $this->getStringOrNullValue($this->get(SubscriptionProcess::THANKYOUURL));
    }

    public function useSingleOptin(): ?bool
    {
        return $this->getBooleanOrNullValue($this->get(SubscriptionProcess::USE_SINGLE_OPTIN));
    }

    public function useDoubleOptin(): ?bool
    {
        return is_null($soi = $this->useSingleOptin()) ? null : !$soi;
    }

    public function resendConfirmationEmail(): ?bool
    {
        return $this->getBooleanOrNullValue($this->get(SubscriptionProcess::RESEND_CONFIRMATION_EMAIL));
    }

    public function useChangeEmail(): ?bool
    {
        return $this->getBooleanOrNullValue($this->get(SubscriptionProcess::USE_CHANGE_EMAIL));
    }

    /**
     * @return null|bool
     * @throws CommunicationException
     * @throws MissingEndpointException
     */
    public function persist(): ?bool
    {
        return !is_null($this->getListId()) ?
            $this->getEndpoint()->update(
                $this->getListId(),
                $this->getName() ?? ''
            ) :
            null;
    }
}
