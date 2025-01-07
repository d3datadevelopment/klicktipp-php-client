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

use D3\KlicktippPhpClient\Entities\Subscription;
use D3\KlicktippPhpClient\Exceptions\InvalidCredentialTypeException;
use D3\KlicktippPhpClient\Resources\SubscriptionProcess as SubscriptionEndpoint;
use D3\KlicktippPhpClient\tests\TestCase;
use Generator;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use ReflectionException;

/**
 * @covers \D3\KlicktippPhpClient\Entities\Subscriber
 */
class SubscriptionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->entity = new Subscription(
            [
                SubscriptionEndpoint::LISTID                    => "368370",
                SubscriptionEndpoint::NAME                      => "subscriptionName",
                SubscriptionEndpoint::PENDINGURL                => "pendingFixture",
                SubscriptionEndpoint::THANKYOUURL               => "thankyouFixture",
                SubscriptionEndpoint::USE_SINGLE_OPTIN          => true,
                SubscriptionEndpoint::RESEND_CONFIRMATION_EMAIL => false,
                SubscriptionEndpoint::USE_CHANGE_EMAIL          => false,

            ]
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::__construct
     */
    public function testConstruct(): void
    {
        $elements = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $endpoint = $this->getMockBuilder(SubscriptionEndpoint::class)
            ->disableOriginalConstructor()
            ->getMock();

        $sut = new Subscription($elements, $endpoint);

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
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getListId
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getName
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getPendingUrl
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getThankyouUrl
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::useSingleOptin
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::useDoubleOptin
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::resendConfirmationEmail
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::useChangeEmail
     * @dataProvider getDataProvider
     */
    public function testGet(string $methodName, bool|string $expectedValue): void
    {
        $this->assertSame(
            $expectedValue,
            $this->callMethod($this->entity, $methodName)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getListId
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getName
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getPendingUrl
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getThankyouUrl
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::useSingleOptin
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::useDoubleOptin
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::resendConfirmationEmail
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::useChangeEmail
     * @dataProvider getDataProvider
     */
    public function testGetNull(string $testMethod): void
    {
        $nullProperties = [];
        foreach (array_keys($this->entity->toArray()) as $key) {
            $nullProperties[$key] = null;
        }

        $sut = new Subscription($nullProperties);

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
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getListId
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getName
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getPendingUrl
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::getThankyouUrl
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::useSingleOptin
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::useDoubleOptin
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::resendConfirmationEmail
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::useChangeEmail
     * @dataProvider getDataProvider
     */
    public function testGetInvalid(string $testMethod): void
    {
        $invalidProperties = [
            SubscriptionEndpoint::LISTID            => [],
            SubscriptionEndpoint::NAME              => [],
            SubscriptionEndpoint::PENDINGURL        => false,
            SubscriptionEndpoint::THANKYOUURL       => [],
            SubscriptionEndpoint::USE_SINGLE_OPTIN  => "string",
            SubscriptionEndpoint::RESEND_CONFIRMATION_EMAIL => [],
            SubscriptionEndpoint::USE_CHANGE_EMAIL  => 'string',
        ];

        $sut = new Subscription($invalidProperties);

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
        yield ['getListId', '368370'];
        yield ['getName', 'subscriptionName'];
        yield ['getPendingUrl', 'pendingFixture'];
        yield ['getThankyouUrl', 'thankyouFixture'];
        yield ['useSingleOptin', true];
        yield ['useDoubleOptin', false];
        yield ['resendConfirmationEmail', false];
        yield ['useChangeEmail', false];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::setName
     */
    public function testSetname(): void {
        $sut = $this->getMockBuilder(Subscription::class)
            ->onlyMethods(['set'])
            ->setConstructorArgs([[SubscriptionEndpoint::LISTID => 'foo']])
            ->getMock();
        $sut->expects($this->once())->method('set')->with(
            $this->identicalTo(SubscriptionEndpoint::NAME)
        );

        $this->callMethod(
            $sut,
            "setName",
            ['newValue']
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscription::persist
     * @dataProvider persistDataProvider
     */
    public function testPersist(
        bool $endpointSet,
        InvokedCount $endpointInvocation,
        ?bool $expectedReturn
    ): void {
        $endpointMock = $this->getMockBuilder(SubscriptionEndpoint::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['update'])
            ->getMock();
        $endpointMock->expects($endpointInvocation)->method('update')->with(
            $this->identicalTo('foo'),
            $this->identicalTo('bar'),
        )->willReturn(true);

        $sut = new Subscription(
            [SubscriptionEndpoint::LISTID => 'foo', SubscriptionEndpoint::NAME  => 'bar'],
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
