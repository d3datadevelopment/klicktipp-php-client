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
use D3\KlicktippPhpClient\Exceptions\InvalidCredentialTypeException;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

abstract class Entity extends ArrayCollection
{
    protected function getDateTimeFromValue($value): ?DateTime
    {
        $this->getStringOrNullValue($value);

        try {
            return $value ?
                new DateTime((string)$value) :
                null;
        } catch (Exception) {
            return null;
        }
    }

    protected function getArrayCollectionFromValue($value): ?ArrayCollection
    {
        Assert::lazy()
              ->setExceptionClass(InvalidCredentialTypeException::class)
              ->that($value)
              ->nullOr()->isArray($value)
              ->verifyNow();

        return is_array($value) ? new ArrayCollection($value) : null;
    }

    /**
     * @throws InvalidCredentialTypeException
     */
    protected function getStringOrNullValue($value): ?string
    {
        Assert::lazy()
            ->setExceptionClass(InvalidCredentialTypeException::class)
            ->that($value)
            ->nullOr()->string()
            ->verifyNow();

        return is_null($value) ? null : (string) $value;
    }

    protected function getIntOrNullValue($value): ?int
    {
        Assert::lazy()
            ->setExceptionClass(InvalidCredentialTypeException::class)
            ->that($value)
            ->nullOr()->integerish($value)
            ->verifyNow();

        return is_null($value) ? null : (int) $value;
    }

    protected function getBooleanOrNullValue($value): ?bool
    {
        Assert::lazy()
            ->setExceptionClass(InvalidCredentialTypeException::class)
            ->that($value)
            ->nullOr()->boolean($value)
            ->verifyNow();

        return is_null($value) ? null : (bool) $value;
    }
}
