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

namespace D3\KlicktippPhpClient\tests;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use ReflectionClass;
use ReflectionException;

abstract class TestCase extends PhpUnitTestCase
{
    /**
     * Calls a private or protected object method.
     *
     * @param object $object
     * @param string $methodName
     * @param array $arguments
     *
     * @return mixed
     * @throws ReflectionException
     */
    public function callMethod(object $object, string $methodName, array $arguments = [])
    {
        $class = new ReflectionClass($object);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $arguments);
    }

    /**
     * Sets a private or protected property in defined class instance
     *
     * @param object $object
     * @param string $valueName
     * @param $value
     * @throws ReflectionException
     */
    public function setValue(object $object, string $valueName, $value): void
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($valueName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * get a private or protected property from defined class instance
     *
     * @param object $object
     * @param string $valueName
     * @return mixed
     * @throws ReflectionException
     */
    public function getValue(object $object, string $valueName)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($valueName);
        $property->setAccessible(true);
        return $property->getValue($object);
    }
}
