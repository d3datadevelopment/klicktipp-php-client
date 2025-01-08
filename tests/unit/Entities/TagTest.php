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

use D3\KlicktippPhpClient\Entities\Tag;
use D3\KlicktippPhpClient\Exceptions\InvalidCredentialTypeException;
use D3\KlicktippPhpClient\Resources\Tag as TagEndpoint;
use D3\KlicktippPhpClient\tests\TestCase;
use Generator;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use ReflectionException;

/**
 * @covers \D3\KlicktippPhpClient\Entities\Tag
 */
class TagTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->entity = new Tag(
            [
                TagEndpoint::ID     => "155988456",
                TagEndpoint::NAME   => "tagName",
                TagEndpoint::TEXT   => "tagText",
            ]
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Tag::__construct
     */
    public function testConstruct(): void
    {
        $elements = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $endpoint = $this->getMockBuilder(TagEndpoint::class)
                         ->disableOriginalConstructor()
                         ->getMock();

        $sut = new Tag($elements, $endpoint);

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
     * @covers \D3\KlicktippPhpClient\Entities\Tag::getId
     * @covers \D3\KlicktippPhpClient\Entities\Tag::getName
     * @covers \D3\KlicktippPhpClient\Entities\Tag::getText
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
     * @covers \D3\KlicktippPhpClient\Entities\Tag::getId
     * @covers \D3\KlicktippPhpClient\Entities\Tag::getName
     * @covers \D3\KlicktippPhpClient\Entities\Tag::getText
     * @dataProvider getDataProvider
     */
    public function testGetNull(string $testMethod): void
    {
        $nullProperties = [];
        foreach (array_keys($this->entity->toArray()) as $key) {
            $nullProperties[$key] = null;
        }

        $sut = new Tag($nullProperties);

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
     * @covers \D3\KlicktippPhpClient\Entities\Tag::getId
     * @covers \D3\KlicktippPhpClient\Entities\Tag::getName
     * @covers \D3\KlicktippPhpClient\Entities\Tag::getText
     * @dataProvider getDataProvider
     */
    public function testGetInvalid(string $testMethod): void
    {
        $invalidProperties = [
            TagEndpoint::ID    => [],
            TagEndpoint::NAME  => [],
            TagEndpoint::TEXT  => [],
        ];

        $sut = new Tag($invalidProperties);

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
        yield ['getName', 'tagName'];
        yield ['getText', 'tagText'];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Tag::setName
     * @covers \D3\KlicktippPhpClient\Entities\Tag::setText
     * @dataProvider setDataProvider
     */
    public function testSetName(string $methodName, string $expectedPropertyName): void
    {
        $sut = $this->getMockBuilder(Tag::class)
                    ->onlyMethods(['set'])
                    ->setConstructorArgs([[TagEndpoint::ID => 'foo']])
                    ->getMock();
        $sut->expects($this->once())->method('set')->with(
            $this->identicalTo($expectedPropertyName)
        );

        $this->callMethod(
            $sut,
            $methodName,
            ['newValue']
        );
    }

    public static function setDataProvider(): Generator
    {
        yield ['setName', TagEndpoint::NAME];
        yield ['setText', TagEndpoint::TEXT];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Tag::persist
     * @dataProvider persistDataProvider
     */
    public function testPersist(
        bool $endpointSet,
        InvokedCount $endpointInvocation,
        ?bool $expectedReturn
    ): void {
        $endpointMock = $this->getMockBuilder(TagEndpoint::class)
                             ->disableOriginalConstructor()
                             ->onlyMethods(['update'])
                             ->getMock();
        $endpointMock->expects($endpointInvocation)->method('update')->willReturn(true);

        $sut = new Tag(
            [TagEndpoint::ID => 'foo', TagEndpoint::NAME => 'name', TagEndpoint::TEXT => 'text'],
            $endpointSet ? $endpointMock : null
        );

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
