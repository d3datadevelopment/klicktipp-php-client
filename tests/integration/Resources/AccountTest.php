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

use D3\KlicktippPhpClient\Entities\Account as AccountEntity;
use D3\KlicktippPhpClient\Exceptions\CommunicationException;
use D3\KlicktippPhpClient\Resources\Account;
use D3\KlicktippPhpClient\tests\integration\IntegrationTestCase;
use Generator;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

/**
 * @coversNothing
 */
class AccountTest extends IntegrationTestCase
{
    /**
     * @test
     * @throws ReflectionException
     * @covers       \D3\KlicktippPhpClient\Resources\Account::login
     * @dataProvider loginDataProvider
     */
    public function testLogin(ResponseInterface $response, array $expected, bool $expectException = false): void
    {
        $sut = new Account($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(CommunicationException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'login',
            )
        );
    }

    public static function loginDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "sessid": "nFnp4uLZCnc3dIEl9PrXgjoUuaJSyJIKpLyU9HH5rxw",
            "session_name": "SSESS5bc3b84d3f2031474d7722e94851cff5",
            "account": {
                "'.Account::UID.'": "12345",
                "'.Account::STATUS.'": "1",
                "'.Account::USERGROUP.'": "16",
                "'.Account::EMAIL.'": "info@mydomain.com",
                "'.Account::USERNAME.'": "KTAPIdev",
                "firstname": "Developer",
                "lastname": "Klicktipper",
                "company": "Customer GmbH",
                "website": "www.mydomain.de",
                "street": "Am Hafen 6",
                "city": "Hamburg",
                "state": "",
                "zip": "20123",
                "country": "DE",
                "phone": "+49211123456789",
                "fax": "",
                "affid": "123456"
            }
        }'), [
            'sessid' => 'nFnp4uLZCnc3dIEl9PrXgjoUuaJSyJIKpLyU9HH5rxw',
            'session_name' => 'SSESS5bc3b84d3f2031474d7722e94851cff5',
            'account' => [
                Account::UID => '12345',
                Account::STATUS => '1',
                Account::USERGROUP => '16',
                Account::EMAIL => 'info@mydomain.com',
                Account::USERNAME => 'KTAPIdev',
                'firstname' => 'Developer',
                'lastname' => 'Klicktipper',
                'company' => 'Customer GmbH',
                'website' => 'www.mydomain.de',
                'street' => 'Am Hafen 6',
                'city' => 'Hamburg',
                'state' => '',
                'zip' => '20123',
                'country' => 'DE',
                'phone' => '+49211123456789',
                'fax' => '',
                'affid' => '123456',
            ],
        ]];
        yield 'wrong credentials' => [new Response(401, [], '["Falscher Benutzername oder Passwort."]'), [], true];
        yield 'already logged in' => [new Response(406, [], '["Sie sind bereits eingeloggt."]'), [], true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers       \D3\KlicktippPhpClient\Resources\Account::logout
     * @dataProvider logoutDataProvider
     */
    public function testLogout(ResponseInterface $response, bool $expected, bool $expectException = false): void
    {
        $sut = new Account($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(CommunicationException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'logout',
            )
        );
    }

    public static function logoutDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'already logged out' => [new Response(406, [], '["Benutzer nicht eingeloggt."]'), false, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Account::get
     * @covers \D3\KlicktippPhpClient\Resources\Account::getEntity
     * @dataProvider getDataProvider
     */
    public function testGet(ResponseInterface $response, ?array $expected, bool $expectException = false): void
    {
        $sut = new Account($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(CommunicationException::class);
        }

        $return = $this->callMethod(
            $sut,
            'getEntity'
        );

        $this->assertInstanceOf(AccountEntity::class, $return);
        $this->assertSame($expected, $return->toArray());
    }

    public static function getDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "'.Account::UID.'": "1084633",
            "'.Account::STATUS.'": "1",
            "'.Account::TIER.'": 1000,
            "'.Account::USERGROUP.'": "16",
            "'.Account::EMAIL.'": "mymail@mydomain.com"
        }'), [
            Account::UID    => "1084633",
            Account::STATUS => "1",
            Account::TIER => 1000,
            Account::USERGROUP => "16",
            Account::EMAIL => "mymail@mydomain.com",
        ]];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Account::update
     * @dataProvider updateDataProvider
     */
    public function testUpdate(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new Account($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(CommunicationException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'update',
                []
            )
        );
    }

    public static function updateDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'access denied' => [new Response(403, [], '["Access denied for user"]'), null, true];
    }
}
