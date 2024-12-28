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

use Doctrine\Common\Collections\ArrayCollection;

class Subscription extends ArrayCollection
{
    public function getListId(): string
    {
        return $this->get('listid') ?? '';
    }

    public function getName(): string
    {
        return $this->get('name') ?? '';
    }

    public function getPendingUrl(): string
    {
        return $this->get('pendingurl') ?? '';
    }

    public function getThankyouUrl(): string
    {
        return $this->get('thankyouurl') ?? '';
    }

    public function useSingleOptin(): bool
    {
        return $this->get('usesingleoptin');
    }

    public function useDoubleOptin(): bool
    {
        return !$this->useSingleOptin();
    }

    public function resendConfirmationEmail(): bool
    {
        return $this->get('resendconfirmationemail');
    }

    public function useChangeEmail(): bool
    {
        return $this->get('usechangeemail');
    }
}
