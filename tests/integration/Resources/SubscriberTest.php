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

namespace D3\KlicktippPhpClient\tests\integration\Resources;

use D3\KlicktippPhpClient\Entities\Subscriber as SubscriberEntity;
use D3\KlicktippPhpClient\Entities\SubscriberList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
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
     * @covers \D3\KlicktippPhpClient\Resources\Subscriber::index
     * @dataProvider indexDataProvider
     */
    public function testIndex(ResponseInterface $response, ?SubscriberList $expected, bool $expectException = false)
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
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
     * @dataProvider getDataProvider
     */
    public function testGet(ResponseInterface $response, ?array $expected, bool $expectException = false)
    {
        $sut = new Subscriber($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $return = $this->callMethod(
            $sut,
            'get',
            ['155988456']
        );

        $this->assertInstanceOf(SubscriberEntity::class, $return);
        $this->assertSame($expected, $return->toArray());
    }

    public static function getDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "id": "155988456",
            "listid": "368370",
            "optin": "28.12.2024 22:52:09",
            "optin_ip": "0.0.0.0 - By API Request",
            "email": "testsubscriber@mydomain.com",
            "status": "Opt-In Pending",
            "bounce": "Not Bounced",
            "date": "",
            "ip": "0.0.0.0 - By API Request",
            "unsubscription": "",
            "unsubscription_ip": "0.0.0.0",
            "referrer": "",
            "sms_phone": null,
            "sms_status": null,
            "sms_bounce": null,
            "sms_date": "",
            "sms_unsubscription": "",
            "sms_referrer": null,
            "fieldFirstName": "",
            "fieldLastName": "",
            "fieldCompanyName": "",
            "fieldStreet1": "",
            "fieldStreet2": "",
            "fieldCity": "",
            "fieldState": "",
            "fieldZip": "",
            "fieldCountry": "",
            "fieldPrivatePhone": "",
            "fieldMobilePhone": "",
            "fieldPhone": "",
            "fieldFax": "",
            "fieldWebsite": "",
            "fieldBirthday": "",
            "fieldLeadValue": ""
        }'), [
            "id"    => "155988456",
            "listid" => "368370",
            "optin" => "28.12.2024 22:52:09",
            "optin_ip" => "0.0.0.0 - By API Request",
            "email" => "testsubscriber@mydomain.com",
            "status" => "Opt-In Pending",
            "bounce" => "Not Bounced",
            "date" => "",
            "ip" => "0.0.0.0 - By API Request",
            "unsubscription" => "",
            "unsubscription_ip" => "0.0.0.0",
            "referrer" => "",
            "sms_phone" => null,
            "sms_status" => null,
            "sms_bounce" => null,
            "sms_date" => "",
            "sms_unsubscription" => "",
            "sms_referrer" => null,
            "fieldFirstName" =>  "",
            "fieldLastName" => "",
            "fieldCompanyName" => "",
            "fieldStreet1" => "",
            "fieldStreet2" =>  "",
            "fieldCity" => "",
            "fieldState" =>  "",
            "fieldZip" => "",
            "fieldCountry" => "",
            "fieldPrivatePhone" => "",
            "fieldMobilePhone" => "",
            "fieldPhone" => "",
            "fieldFax" => "",
            "fieldWebsite" => "",
            "fieldBirthday" => "",
            "fieldLeadValue" => "",
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
            $this->expectException(BaseException::class);
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
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'subscribe',
                ['testsubscriber@mydomain.com']
            )
        );
    }

    public static function subscribeDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "id": "155988456",
            "listid": "368370",
            "optin": "28.12.2024 22:52:09",
            "optin_ip": "0.0.0.0 - By API Request",
            "email": "testsubscriber@mydomain.com",
            "status": "Opt-In Pending",
            "bounce": "Not Bounced",
            "date": "",
            "ip": "0.0.0.0 - By API Request",
            "unsubscription": "",
            "unsubscription_ip": "0.0.0.0",
            "referrer": "",
            "sms_phone": null,
            "sms_status": null,
            "sms_bounce": null,
            "sms_date": "",
            "sms_unsubscription": "",
            "sms_referrer": null,
            "fieldFirstName": "",
            "fieldLastName": "",
            "fieldCompanyName": "",
            "fieldStreet1": "",
            "fieldStreet2": "",
            "fieldCity": "",
            "fieldState": "",
            "fieldZip": "",
            "fieldCountry": "",
            "fieldPrivatePhone": "",
            "fieldMobilePhone": "",
            "fieldPhone": "",
            "fieldFax": "",
            "fieldWebsite": "",
            "fieldBirthday": "",
            "fieldLeadValue": ""
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
            $this->expectException(BaseException::class);
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
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'tag',
                ['testsubscriber@mydomain.com', ['2354758', ' 2354858']]
            )
        );
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
            $this->expectException(BaseException::class);
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
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'tagged',
                ['2354758']
            )
        );
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
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'update',
                ['2354758', ['fieldCity'    => 'Berlin', 'fieldStreet2' => 'Straße unter den Linden 25'], 'mymail@mydomain.com']
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
            $this->expectException(BaseException::class);
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
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'signin',
                ['7gefzp8255z8z8469', 'subsriber@mydomain.com']
            )
        );
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
            $this->expectException(BaseException::class);
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
            $this->expectException(BaseException::class);
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
            ->onlyMethods(['search', 'update', 'subscribe', 'get'])
            ->getMock();
        $sut->expects($this->once())->method('search')->will(
            $foundId ? $this->returnValue($foundId) : $this->throwException(new BaseException())
        );
        $sut->expects($updateInvocations)->method('update')->willReturn(true);
        $sut->expects($subscribeInvocations)->method('subscribe')->willReturn('myId');
        $sut->expects($this->once())->method('get')->with(
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
            ->onlyMethods(['search', 'get'])
            ->getMock();
        $sut->expects($this->once())->method('search')->willReturn('myId');
        $sut->expects($this->once())->method('get')->with(
            $this->identicalTo('myId')
        )->willReturn(new SubscriberEntity());

        $this->callMethod(
            $sut,
            'getSubscriberByMailAddress',
            ['myMailAddress']
        );
    }
}
