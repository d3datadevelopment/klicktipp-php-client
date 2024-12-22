<?php

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