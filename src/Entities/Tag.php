<?php

namespace D3\KlicktippPhpClient\Entities;

use Doctrine\Common\Collections\ArrayCollection;

class Tag extends ArrayCollection
{
    public function getId(): string
    {
        return $this->get('tagid');
    }

    public function getName(): string
    {
        return $this->get('name');
    }

    public function getText(): string
    {
        return $this->get('text');
    }
}