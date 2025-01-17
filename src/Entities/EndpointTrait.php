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
use D3\KlicktippPhpClient\Exceptions\MissingEndpointException;
use D3\KlicktippPhpClient\Resources\Model;

trait EndpointTrait
{
    private function getEndpoint(): Model
    {
        Assert::lazy()
              ->setExceptionClass(MissingEndpointException::class)
              ->that($this->endpoint)
              ->isInstanceOf(Model::class)
              ->verifyNow();

        return $this->endpoint;
    }
}
