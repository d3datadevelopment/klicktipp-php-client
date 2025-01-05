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
use D3\KlicktippPhpClient\Resources\Tag as TagEndpoint;
use Doctrine\Common\Collections\ArrayCollection;

class Tag extends ArrayCollection
{
    private ?TagEndpoint $endpoint;

    public function __construct(array $elements = [], ?TagEndpoint $endpoint = null)
    {
        $this->endpoint = $endpoint;
        parent::__construct($elements);
    }

    public function getId(): string
    {
        return $this->get(TagEndpoint::ID);
    }

    public function getName(): string
    {
        return $this->get(TagEndpoint::NAME);
    }

    public function setName(string $name): void
    {
        $this->set(TagEndpoint::NAME, $name);

        // use persist method to send to Klicktipp
    }

    public function getText(): string
    {
        return $this->get(TagEndpoint::TEXT);
    }

    public function setText(string $text): void
    {
        $this->set(TagEndpoint::TEXT, $text);

        // use persist method to send to Klicktipp
    }

    /**
     * @return null|bool
     * @throws BaseException
     */
    public function persist(): ?bool
    {
        return $this->endpoint?->update(
            $this->getId(),
            $this->getName(),
            $this->getText()
        );
    }
}
