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

namespace D3\KlicktippPhpClient\tests\integration\Resources;

use D3\KlicktippPhpClient\Entities\Subscriber as SubscriberEntity;
use D3\KlicktippPhpClient\Entities\SubscriberList;
use D3\KlicktippPhpClient\Exceptions\CommunicationException;
use D3\KlicktippPhpClient\Exceptions\KlicktippExceptionInterface;
use D3\KlicktippPhpClient\Resources\Subscriber;
use D3\KlicktippPhpClient\tests\integration\IntegrationTestCase;
use Generator;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

/**
 * @coversNothing
 */
class SubscriberTest extends IntegrationTestCase
{
    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Model::__construct
     */
    public function testConstruct(): void
    {
        $connection = $this->getConnectionMock(new Response(200, [], json_encode([])));
        $sut = new Subscriber($connection);

        $this->assertSame(
            $connection,
            $this->getValue($sut, 'connection')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::index
     * @dataProvider indexDataProvider
     */
    public function testIndex(ResponseInterface $response, ?SubscriberList $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(CommunicationException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'index',
            )
        );
    }

    public static function indexDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[
            "29513792",
            "29513793",
            "29513794",
            "29513795"
        ]'), new SubscriberList([
            "29513792",
            "29513793",
            "29513794",
            "29513795",
        ])];
        yield 'no subscriber available' => [new Response(404, [], '["Es existieren keine Kontakte."]'), null, true];
        yield 'wrong request type' => [new Response(406, [], '["Bei der Erstellung des Objekt ist ein Fehler aufgetreten."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::get
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::getEntity
     * @dataProvider getDataProvider
     */
    public function testGet(ResponseInterface $response, ?array $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(KlicktippExceptionInterface::class);
        }

        $return = $this->callMethod(
            $sut,
            'getEntity',
            ['155988456']
        );

        $this->assertInstanceOf(SubscriberEntity::class, $return);
        $this->assertSame($expected, $return->toArray());
    }

    public static function getDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "'.Subscriber::ID.'": "155988456",
            "'.Subscriber::LISTID.'": "368370",
            "'.Subscriber::OPTIN.'": "28.12.2024 22:52:09",
            "'.Subscriber::OPTIN_IP.'": "0.0.0.0 - By API Request",
            "'.Subscriber::EMAIL.'": "testsubscriber@mydomain.com",
            "'.Subscriber::STATUS.'": "Opt-In Pending",
            "'.Subscriber::BOUNCE.'": "Not Bounced",
            "'.Subscriber::DATE.'": "",
            "'.Subscriber::IP.'": "0.0.0.0 - By API Request",
            "'.Subscriber::UNSUBSCRIPTION.'": "",
            "'.Subscriber::UNSUBSCRIPTION_IP.'": "0.0.0.0",
            "'.Subscriber::REFERRER.'": "",
            "'.Subscriber::SMS_PHONE.'": null,
            "'.Subscriber::SMS_STATUS.'": null,
            "'.Subscriber::SMS_BOUNCE.'": null,
            "'.Subscriber::SMS_DATE.'": "",
            "'.Subscriber::SMS_UNSUBSCRIPTION.'": "",
            "'.Subscriber::SMS_REFERRER.'": null,
            "'.Subscriber::FIELD_FIRSTNAME.'": "",
            "'.Subscriber::FIELD_LASTNAME.'": "",
            "'.Subscriber::FIELD_COMPANYNAME.'": "",
            "'.Subscriber::FIELD_STREET1.'": "",
            "'.Subscriber::FIELD_STREET2.'": "",
            "'.Subscriber::FIELD_CITY.'": "",
            "'.Subscriber::FIELD_STATE.'": "",
            "'.Subscriber::FIELD_ZIP.'": "",
            "'.Subscriber::FIELD_COUNTRY.'": "",
            "'.Subscriber::FIELD_PRIVATEPHONE.'": "",
            "'.Subscriber::FIELD_MOBILEPHONE.'": "",
            "'.Subscriber::FIELD_PHONE.'": "",
            "'.Subscriber::FIELD_FAX.'": "",
            "'.Subscriber::FIELD_WEBSITE.'": "",
            "'.Subscriber::FIELD_BIRTHDAY.'": "",
            "'.Subscriber::FIELD_LEADVALUE.'": ""
        }'), [
            Subscriber::ID    => "155988456",
            Subscriber::LISTID => "368370",
            Subscriber::OPTIN => "28.12.2024 22:52:09",
            Subscriber::OPTIN_IP => "0.0.0.0 - By API Request",
            Subscriber::EMAIL => "testsubscriber@mydomain.com",
            Subscriber::STATUS => "Opt-In Pending",
            Subscriber::BOUNCE => "Not Bounced",
            Subscriber::DATE => "",
            Subscriber::IP => "0.0.0.0 - By API Request",
            Subscriber::UNSUBSCRIPTION => "",
            Subscriber::UNSUBSCRIPTION_IP => "0.0.0.0",
            Subscriber::REFERRER => "",
            Subscriber::SMS_PHONE => null,
            Subscriber::SMS_STATUS => null,
            Subscriber::SMS_BOUNCE => null,
            Subscriber::SMS_DATE => "",
            Subscriber::SMS_UNSUBSCRIPTION => "",
            Subscriber::SMS_REFERRER => null,
            Subscriber::FIELD_FIRSTNAME =>  "",
            Subscriber::FIELD_LASTNAME => "",
            Subscriber::FIELD_COMPANYNAME => "",
            Subscriber::FIELD_STREET1 => "",
            Subscriber::FIELD_STREET2 =>  "",
            Subscriber::FIELD_CITY => "",
            Subscriber::FIELD_STATE =>  "",
            Subscriber::FIELD_ZIP => "",
            Subscriber::FIELD_COUNTRY => "",
            Subscriber::FIELD_PRIVATEPHONE => "",
            Subscriber::FIELD_MOBILEPHONE => "",
            Subscriber::FIELD_PHONE => "",
            Subscriber::FIELD_FAX => "",
            Subscriber::FIELD_WEBSITE => "",
            Subscriber::FIELD_BIRTHDAY => "",
            Subscriber::FIELD_LEADVALUE => "",
        ]];
        yield 'unknown id' => [new Response(404, [], ''), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::search
     * @dataProvider searchDataProvider
     */
    public function testSearch(ResponseInterface $response, ?string $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(KlicktippExceptionInterface::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'search',
                ['testsubscriber@mydomain.com']
            )
        );
    }

    public static function searchDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[155986456]'), '155986456'];
        yield 'unknown id' => [new Response(404, [], '[Diesen Kontakt gibt es nicht.]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::subscribe
     * @dataProvider subscribeDataProvider
     */
    public function testSubscribe(ResponseInterface $response, ?string $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(CommunicationException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'subscribe',
                ['testsubscriber@mydomain.com', '1234567', '2345678', ['field1' => 'abcd', 'field2' => 'efgh']]
            )
        );

        /** @var RequestInterface $request */
        $request = current($this->getHistoryContainer())['request'];
        $requestFormParams = $request->getBody()->getContents();
        $this->assertMatchesRegularExpression('/fields%5Bfield1%5D=abcd/m', $requestFormParams);
        $this->assertMatchesRegularExpression('/fields%5Bfield2%5D=efgh/m', $requestFormParams);
        $this->assertMatchesRegularExpression('/email=testsubscriber%40mydomain.com/m', $requestFormParams);
    }

    public static function subscribeDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "'.Subscriber::ID.'": "155988456",
            "'.Subscriber::LISTID.'": "368370",
            "'.Subscriber::OPTIN.'": "28.12.2024 22:52:09",
            "'.Subscriber::OPTIN_IP.'": "0.0.0.0 - By API Request",
            "'.Subscriber::EMAIL.'": "testsubscriber@mydomain.com",
            "'.Subscriber::STATUS.'": "Opt-In Pending",
            "'.Subscriber::BOUNCE.'": "Not Bounced",
            "'.Subscriber::DATE.'": "",
            "'.Subscriber::IP.'": "0.0.0.0 - By API Request",
            "'.Subscriber::UNSUBSCRIPTION.'": "",
            "'.Subscriber::UNSUBSCRIPTION_IP.'": "0.0.0.0",
            "'.Subscriber::REFERRER.'": "",
            "'.Subscriber::SMS_PHONE.'": null,
            "'.Subscriber::SMS_STATUS.'": null,
            "'.Subscriber::SMS_BOUNCE.'": null,
            "'.Subscriber::SMS_DATE.'": "",
            "'.Subscriber::SMS_UNSUBSCRIPTION.'": "",
            "'.Subscriber::SMS_REFERRER.'": null,
            "'.Subscriber::FIELD_FIRSTNAME.'": "",
            "'.Subscriber::FIELD_LASTNAME.'": "",
            "'.Subscriber::FIELD_COMPANYNAME.'": "",
            "'.Subscriber::FIELD_STREET1.'": "",
            "'.Subscriber::FIELD_STREET2.'": "",
            "'.Subscriber::FIELD_CITY.'": "",
            "'.Subscriber::FIELD_STATE.'": "",
            "'.Subscriber::FIELD_ZIP.'": "",
            "'.Subscriber::FIELD_COUNTRY.'": "",
            "'.Subscriber::FIELD_PRIVATEPHONE.'": "",
            "'.Subscriber::FIELD_MOBILEPHONE.'": "",
            "'.Subscriber::FIELD_PHONE.'": "",
            "'.Subscriber::FIELD_FAX.'": "",
            "'.Subscriber::FIELD_WEBSITE.'": "",
            "'.Subscriber::FIELD_BIRTHDAY.'": "",
            "'.Subscriber::FIELD_LEADVALUE.'": ""
        }'), '155988456'];
        yield 'missing mail' => [new Response(401, [], '{"error": 32}'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::unsubscribe
     * @dataProvider unsubscribeDataProvider
     */
    public function testUnsubscribe(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(KlicktippExceptionInterface::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'unsubscribe',
                ['testsubscriber@mydomain.com']
            )
        );
    }

    public static function unsubscribeDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'missing mail' => [new Response(401, [], '[Missing required argument email]'), null, true];
        yield 'unknown mail' => [new Response(406, [], '{"error": 7}'), null, true];
        yield 'pending opt in' => [new Response(406, [], '{"error": 9}'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::tag
     * @dataProvider tagDataProvider
     */
    public function testTag(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(KlicktippExceptionInterface::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'tag',
                ['testsubscriber@mydomain.com', ['2354758', ' 2354858']]
            )
        );

        /** @var RequestInterface $request */
        $request = current($this->getHistoryContainer())['request'];
        $requestFormParams = $request->getBody()->getContents();
        $this->assertMatchesRegularExpression('/tagids%5B0%5D=2354758/m', $requestFormParams);
        $this->assertMatchesRegularExpression('/tagids%5B1%5D=2354858/m', $requestFormParams);
        $this->assertMatchesRegularExpression('/email=testsubscriber%40mydomain.com/m', $requestFormParams);
    }

    public static function tagDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'missing mail' => [new Response(401, [], '[Missing required argument email]'), null, true];
        yield 'unknown mail / tag' => [new Response(406, [], '{"error": 7}'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::untag
     * @dataProvider untagDataProvider
     */
    public function testUntag(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(KlicktippExceptionInterface::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'untag',
                ['testsubscriber@mydomain.com', '2354758']
            )
        );
    }

    public static function untagDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'missing mail' => [new Response(401, [], '[Missing required argument email]'), null, true];
        yield 'unknown mail' => [new Response(406, [], '{"error": 7}'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::tagged
     * @dataProvider taggedDataProvider
     */
    public function testTagged(ResponseInterface $response, ?array $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(KlicktippExceptionInterface::class);
        }

        $return = $this->callMethod(
            $sut,
            'tagged',
            ['2354758']
        );

        $this->assertInstanceOf(SubscriberList::class, $return);
        $this->assertSame($expected, $return->toArray());
    }

    public static function taggedDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "155986456": "1735426641",
            "155986457": "1735426642"
        }'), [
            "155986456" => "1735426641",
            "155986457" => "1735426642",
        ]];
        yield 'missing tagid' => [new Response(401, [], '[Missing required argument tagid]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::update
     * @dataProvider updateDataProvider
     */
    public function testUpdate(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(CommunicationException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'update',
                ['2354758', [Subscriber::FIELD_CITY    => 'Berlin', Subscriber::FIELD_STREET2 => 'Straße unter den Linden 25'], 'mymail@mydomain.com']
            )
        );

        /** @var RequestInterface $request */
        $request = current($this->getHistoryContainer())['request'];
        $requestFormParams = $request->getBody()->getContents();
        $this->assertMatchesRegularExpression('/fields%5BfieldCity%5D=Berlin/m', $requestFormParams);
        $this->assertMatchesRegularExpression('/fields%5BfieldStreet2%5D=Stra%C3%9Fe\+unter\+den\+Linden\+25/m', $requestFormParams);
        $this->assertMatchesRegularExpression('/newemail=mymail%40mydomain.com/m', $requestFormParams);
    }

    public static function updateDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'unknown subscriber' => [new Response(406, [], '["Der Kontakt existiert nicht."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::delete
     * @dataProvider deleteDataProvider
     */
    public function testDelete(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(CommunicationException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'delete',
                ['2354758']
            )
        );
    }

    public static function deleteDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::signin
     * @dataProvider signinDataProvider
     */
    public function testSignin(ResponseInterface $response, ?string $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(KlicktippExceptionInterface::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'signin',
                ['7gefzp8255z8z8469', 'subsriber@mydomain.com', ['field1'   => 'abcd', 'field2'   => 'efgh']]
            )
        );

        /** @var RequestInterface $request */
        $request = current($this->getHistoryContainer())['request'];
        $requestFormParams = $request->getBody()->getContents();
        $this->assertMatchesRegularExpression('/fields%5Bfield1%5D=abcd/m', $requestFormParams);
        $this->assertMatchesRegularExpression('/fields%5Bfield2%5D=efgh/m', $requestFormParams);
        $this->assertMatchesRegularExpression('/apikey=7gefzp8255z8z8469/m', $requestFormParams);
    }

    public static function signinDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '["https://klick.marketron.io/pending/p9i3z8e6az2xxgcnzzpze5fa"]'), 'https://klick.marketron.io/pending/p9i3z8e6az2xxgcnzzpze5fa'];
        yield 'missing mandatory data' => [new Response(401, [], '["Missing required argument apikey"]'), null, true];
        yield 'wrong api key' => [new Response(500, [], ''), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::signout
     * @dataProvider signoutDataProvider
     */
    public function testSignout(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(CommunicationException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'signout',
                ['7gefzp8255z8z8469', 'subsriber@mydomain.com']
            )
        );
    }

    public static function signoutDataProvider(): Generator
    {
        // ToDo: unknown success result
        //yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'unknown error' => [new Response(406, [], '{"error": 403}'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::signoff
     * @dataProvider signoffDataProvider
     */
    public function testSignoff(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(CommunicationException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'signoff',
                ['7gefzp8255z8z8469', 'subsriber@mydomain.com']
            )
        );
    }

    public static function signoffDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'unknown subsriber' => [new Response(406, [], '{"error": 9}'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::setSubscriber
     * @dataProvider setSubscriberDataProvider
     */
    public function testSetSubscriber(
        array $responses,
        ?string $foundId,
        InvokedCount $updateInvocations,
        InvokedCount $subscribeInvocations
    ): void {
        $entityMock = $this->getMockBuilder(SubscriberEntity::class)
            ->getMock();

        $sut = $this->getMockBuilder(Subscriber::class)
            ->setConstructorArgs([$this->getConnectionMock($responses)])
            ->onlyMethods(['search', 'update', 'subscribe', 'getEntity'])
            ->getMock();
        $sut->expects($this->once())->method('search')->will(
            $foundId ? $this->returnValue($foundId) : $this->throwException(new CommunicationException())
        );
        $sut->expects($updateInvocations)->method('update')->willReturn(true);
        $sut->expects($subscribeInvocations)->method('subscribe')->willReturn('myId');
        $sut->expects($this->once())->method('getEntity')->with(
            $this->identicalTo('myId')
        )->willReturn($entityMock);

        $this->callMethod(
            $sut,
            'setSubscriber',
            ['oldMailAddress']
        );
    }

    public static function setSubscriberDataProvider(): Generator
    {
        yield 'update' => [
            [
                new Response(200, [], '[true]'),
                new Response(200, [], '[true]'),
                new Response(200, [], '[true]'),
            ],
            'myId',
            self::once(),
            self::never(),
        ];
        yield 'subscribe' => [
            [
                new Response(200, [], '[true]'),
                new Response(200, [], '[true]'),
                new Response(200, [], '[true]'),
            ],
            null,
            self::never(),
            self::once(),
        ];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::getSubscriberByMailAddress
     */
    public function testGetSubscriberByMailAddress(): void
    {
        $responses = [
            new Response(200, [], '[true]'),
            new Response(200, [], '[true]'),
        ];

        $sut = $this->getMockBuilder(Subscriber::class)
            ->setConstructorArgs([$this->getConnectionMock($responses)])
            ->onlyMethods(['search', 'getEntity'])
            ->getMock();
        $sut->expects($this->once())->method('search')->willReturn('myId');
        $sut->expects($this->once())->method('getEntity')->with(
            $this->identicalTo('myId')
        )->willReturn(new SubscriberEntity());

        $this->callMethod(
            $sut,
            'getSubscriberByMailAddress',
            ['myMailAddress']
        );
    }
}
