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
use D3\KlicktippPhpClient\Resources\Tag as TagEndpoint;

class Tag extends Entity
{
    private ?TagEndpoint $endpoint;

    public function __construct(array $elements = [], ?TagEndpoint $endpoint = null)
    {
        $this->endpoint = $endpoint;
        parent::__construct($elements);
    }

    private function getEndpoint(): TagEndpoint
    {
        Assert::lazy()
            ->setExceptionClass(MissingEndpointException::class)
            ->that($this->endpoint)
            ->isInstanceOf(TagEndpoint::class)
            ->verifyNow();

        return $this->endpoint;
    }

    public function getId(): ?string
    {
        return $this->getStringOrNullValue($this->get(TagEndpoint::ID));
    }

    public function getName(): ?string
    {
        return $this->getStringOrNullValue($this->get(TagEndpoint::NAME));
    }

    public function setName(string $name): void
    {
        $this->set(TagEndpoint::NAME, $name);

        // use persist method to send to Klicktipp
    }

    public function getText(): ?string
    {
        return $this->getStringOrNullValue($this->get(TagEndpoint::TEXT));
    }

    public function setText(string $text): void
    {
        $this->set(TagEndpoint::TEXT, $text);

        // use persist method to send to Klicktipp
    }

    /**
     * @return null|bool
     * @throws CommunicationException
     * @throws MissingEndpointException
     */
    public function persist(): ?bool
    {
        return !is_null($this->getId()) ?
            $this->getEndpoint()->update(
                $this->getId(),
                $this->getName() ?? '',
                $this->getText() ?? ''
            ) :
            null;
    }
}
