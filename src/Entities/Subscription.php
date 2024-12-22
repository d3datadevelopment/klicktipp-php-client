<?php

namespace D3\KlicktippPhpClient\Entities;

use Doctrine\Common\Collections\ArrayCollection;

class Subscription extends ArrayCollection
{
    public function getId(): string
    {
        return $this->get('id');
    }
}