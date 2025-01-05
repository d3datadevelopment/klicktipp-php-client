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
use D3\KlicktippPhpClient\Resources\SubscriptionProcess;
use Doctrine\Common\Collections\ArrayCollection;

class Subscription extends ArrayCollection
{
    private ?SubscriptionProcess $endpoint;

    public function __construct(array $elements = [], ?SubscriptionProcess $endpoint = null)
    {
        $this->endpoint = $endpoint;
        parent::__construct($elements);
    }

    public function getListId(): string
    {
        return $this->get(SubscriptionProcess::LISTID) ?? '';
    }

    public function getName(): string
    {
        return $this->get(SubscriptionProcess::NAME) ?? '';
    }

    public function setName(string $name): void
    {
        $this->set(SubscriptionProcess::NAME, $name);
    }

    public function getPendingUrl(): string
    {
        return $this->get(SubscriptionProcess::PENDINGURL) ?? '';
    }

    public function getThankyouUrl(): string
    {
        return $this->get(SubscriptionProcess::THANKYOUURL) ?? '';
    }

    public function useSingleOptin(): bool
    {
        return $this->get(SubscriptionProcess::USE_SINGLE_OPTIN);
    }

    public function useDoubleOptin(): bool
    {
        return !$this->useSingleOptin();
    }

    public function resendConfirmationEmail(): bool
    {
        return $this->get(SubscriptionProcess::RESEND_CONFIRMATION_EMAIL);
    }

    public function useChangeEmail(): bool
    {
        return $this->get(SubscriptionProcess::USE_CHANGE_EMAIL);
    }

    /**
     * @return null|bool
     * @throws BaseException
     */
    public function persist(): ?bool
    {
        return $this->endpoint?->update(
            $this->getListId(),
            $this->getName()
        );
    }
}
