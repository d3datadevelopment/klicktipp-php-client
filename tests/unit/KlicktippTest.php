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

namespace D3\KlicktippPhpClient\tests\unit;

use D3\KlicktippPhpClient\Connection;
use D3\KlicktippPhpClient\Klicktipp;
use D3\KlicktippPhpClient\Resources\Account;
use D3\KlicktippPhpClient\Resources\Field;
use D3\KlicktippPhpClient\Resources\Subscriber;
use D3\KlicktippPhpClient\Resources\SubscriptionProcess;
use D3\KlicktippPhpClient\Resources\Tag;
use D3\KlicktippPhpClient\tests\TestCase;
use Generator;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use ReflectionException;

/**
 * @covers \D3\KlicktippPhpClient\Klicktipp
 */
class KlicktippTest extends TestCase
{
    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Klicktipp::__construct
     * @dataProvider constructDataProvider
     */
    public function testConstruct(?ClientInterface $client): void
    {
        $accountMock = $this->getMockBuilder(Account::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['login'])
            ->getMock();
        $accountMock->expects($this->once())->method('login');

        $connectionMock = $this->getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setClient'])
            ->getMock();
        $connectionMock->expects($client ? $this->once() : $this->never())->method('setClient');

        $sut = $this->getMockBuilder(Klicktipp::class)
            ->onlyMethods(['account', 'getConnection'])
            ->disableOriginalConstructor()
            ->getMock();
        $sut->method('account')->willReturn($accountMock);
        $sut->method('getConnection')->willReturn($connectionMock);

        $this->callMethod(
            $sut,
            '__construct',
            ['client', 'secret', $client]
        );
    }

    public static function constructDataProvider(): Generator
    {
        yield 'no client'   => [null];
        yield 'has client'   => [new Client()];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Klicktipp::getConnection
     */
    public function testGetConnection(): void
    {
        $accountMock = $this->getMockBuilder(Account::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['login'])
            ->getMock();
        $accountMock->expects($this->never())->method('login');

        $sutMock = $this->getMockBuilder(Klicktipp::class)
            ->setConstructorArgs(['foo', 'bar'])
            ->onlyMethods(['account'])
            ->getMock();
        $sutMock->method('account')->willReturn($accountMock);

        // not set property
        $firstReturn = $this->callMethod(
            $sutMock,
            'getConnection',
        );

        // already set property
        $secondReturn = $this->callMethod(
            $sutMock,
            'getConnection',
        );

        $this->assertSame($firstReturn, $secondReturn);
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Klicktipp::subscription
     * @covers \D3\KlicktippPhpClient\Klicktipp::account
     * @covers \D3\KlicktippPhpClient\Klicktipp::field
     * @covers \D3\KlicktippPhpClient\Klicktipp::subscriber
     * @covers \D3\KlicktippPhpClient\Klicktipp::tag
     * @dataProvider instanceGetterDataProvider
     */
    public function testInstanceGetter(string $testMethodName, string $expectedClassName): void
    {
        $connectionMock = $this->getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $sutMock = $this->getMockBuilder(Klicktipp::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getConnection'])
            ->getMock();
        $sutMock->expects($this->once())->method('getConnection')->willReturn($connectionMock);

        $this->assertInstanceOf(
            $expectedClassName,
            $this->callMethod(
                $sutMock,
                $testMethodName,
            )
        );
    }

    public static function instanceGetterDataProvider(): Generator
    {
        yield ['subscription', SubscriptionProcess::class];
        yield ['account', Account::class];
        yield ['field', Field::class];
        yield ['subscriber', Subscriber::class];
        yield ['tag', Tag::class];
    }
}
