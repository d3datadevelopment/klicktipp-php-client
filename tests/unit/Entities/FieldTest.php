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

namespace D3\KlicktippPhpClient\tests\unit\Entities;

use D3\KlicktippPhpClient\Entities\Field;
use D3\KlicktippPhpClient\Exceptions\InvalidCredentialTypeException;
use D3\KlicktippPhpClient\Exceptions\MissingEndpointException;
use D3\KlicktippPhpClient\Resources\Field as FieldEndpoint;
use D3\KlicktippPhpClient\tests\TestCase;
use Generator;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use ReflectionException;

/**
 * @covers \D3\KlicktippPhpClient\Entities\Field
 */
class FieldTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->entity = new Field(
            [
                FieldEndpoint::ID    => "155988456",
                FieldEndpoint::NAME  => "fieldName",
            ]
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Field::__construct
     */
    public function testConstruct(): void
    {
        $elements = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $endpoint = $this->getMockBuilder(FieldEndpoint::class)
            ->disableOriginalConstructor()
            ->getMock();

        $sut = new Field($elements, $endpoint);

        $this->assertSame(
            $elements,
            $sut->toArray()
        );
        $this->assertSame(
            $endpoint,
            $this->getValue($sut, 'endpoint')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Field::getId
     * @covers \D3\KlicktippPhpClient\Entities\Field::getName
     * @dataProvider getDataProvider
     */
    public function testGet(string $methodName, string $expectedValue): void
    {
        $this->assertSame(
            $expectedValue,
            $this->callMethod($this->entity, $methodName)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Field::getId
     * @covers \D3\KlicktippPhpClient\Entities\Field::getName
     * @dataProvider getDataProvider
     */
    public function testGetNull(string $testMethod): void
    {
        $nullProperties = [];
        foreach (array_keys($this->entity->toArray()) as $key) {
            $nullProperties[$key] = null;
        }

        $sut = new Field($nullProperties);

        $this->assertNull(
            $this->callMethod(
                $sut,
                $testMethod,
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Field::getId
     * @covers \D3\KlicktippPhpClient\Entities\Field::getName
     * @dataProvider getDataProvider
     */
    public function testGetInvalid(string $testMethod): void
    {
        $invalidProperties = [
            FieldEndpoint::ID    => [],
            FieldEndpoint::NAME  => [],
        ];

        $sut = new Field($invalidProperties);

        $this->expectException(InvalidCredentialTypeException::class);

        $this->assertNull(
            $this->callMethod(
                $sut,
                $testMethod,
            )
        );
    }

    public static function getDataProvider(): Generator
    {
        yield ['getId', '155988456'];
        yield ['getName', 'fieldName'];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Field::setName
     */
    public function testSetName(): void
    {
        $sut = $this->getMockBuilder(Field::class)
            ->onlyMethods(['set'])
            ->setConstructorArgs([[FieldEndpoint::ID => 'foo']])
            ->getMock();
        $sut->expects($this->once())->method('set')->with(
            $this->identicalTo(FieldEndpoint::NAME)
        );

        $this->callMethod(
            $sut,
            'setName',
            ['newValue']
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Field::persist
     * @dataProvider persistDataProvider
     */
    public function testPersist(
        bool $endpointSet,
        InvokedCount $endpointInvocation,
        ?bool $expectedReturn
    ): void {
        $endpointMock = $this->getMockBuilder(FieldEndpoint::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['update'])
            ->getMock();
        $endpointMock->expects($endpointInvocation)->method('update')->willReturn(true);

        $sut = new Field(
            [FieldEndpoint::ID => 'foo', FieldEndpoint::NAME => 'name'],
            $endpointSet ? $endpointMock : null
        );

        if (!$endpointSet) {
            $this->expectException(MissingEndpointException::class);
        }

        $this->assertSame(
            $expectedReturn,
            $this->callMethod(
                $sut,
                'persist'
            )
        );
    }

    public static function persistDataProvider(): Generator
    {
        yield 'has endpoint'    => [true, self::once(), true];
        yield 'has no endpoint'    => [false, self::never(), null];
    }
}
