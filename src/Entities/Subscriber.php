<?php

namespace D3\KlicktippPhpClient\Entities;

use Doctrine\Common\Collections\ArrayCollection;

class Subscriber extends ArrayCollection
{
    public function getId(): string
    {
        return $this->get('id');
    }

    public function isSubscribed(): bool
    {
        // ToDo: adjust request
        return $this->get('isSubscribed');
    }
}