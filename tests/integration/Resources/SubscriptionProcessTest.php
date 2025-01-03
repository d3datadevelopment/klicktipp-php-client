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

use D3\KlicktippPhpClient\Entities\Subscription;
use D3\KlicktippPhpClient\Entities\SubscriptionList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use D3\KlicktippPhpClient\Resources\SubscriptionProcess;
use D3\KlicktippPhpClient\tests\integration\IntegrationTestCase;
use Generator;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

/**
 * @coversNothing
 */
class SubscriptionProcessTest extends IntegrationTestCase
{
    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\SubscriptionProcess::index
     * @dataProvider indexDataProvider
     */
    public function testIndex(ResponseInterface $response, ?SubscriptionList $expected, bool $expectException = false)
    {
        $sut = new SubscriptionProcess($this->getConnectionMock($response));

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
        yield 'success' => [new Response(200, [], '{
            "470370": "name 1",
            "470371": "name 2"
        }'), new SubscriptionList([
            "470370"    => "name 1",
            "470371"    => "name 2",
        ])];
        yield 'wrong request type' => [new Response(409, [], '["A list with the name  already exists."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\SubscriptionProcess::get
     * @dataProvider getDataProvider
     */
    public function testGet(ResponseInterface $response, ?Subscription $expected, bool $expectException = false)
    {
        $sut = new SubscriptionProcess($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'get',
                ['470370']
            )
        );
    }

    public static function getDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "'.SubscriptionProcess::LISTID.'": "470370",
            "'.SubscriptionProcess::NAME.'": "name 1",
            "'.SubscriptionProcess::PENDINGURL.'": "",
            "'.SubscriptionProcess::THANKYOUURL.'": "",
            "'.SubscriptionProcess::USE_SINGLE_OPTIN.'": false,
            "'.SubscriptionProcess::RESEND_CONFIRMATION_EMAIL.'": false,
            "'.SubscriptionProcess::USE_CHANGE_EMAIL.'": false
        }'), new Subscription([
            SubscriptionProcess::LISTID    => "470370",
            SubscriptionProcess::NAME      => "name 1",
            SubscriptionProcess::PENDINGURL => "",
            SubscriptionProcess::THANKYOUURL => "",
            SubscriptionProcess::USE_SINGLE_OPTIN => false,
            SubscriptionProcess::RESEND_CONFIRMATION_EMAIL => false,
            SubscriptionProcess::USE_CHANGE_EMAIL => false,
        ])];
        yield 'unknown id' => [new Response(404, [], '["Kein Opt-In-Prozess mit dieser ID."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\SubscriptionProcess::create
     * @dataProvider getDataProvider
     */
    public function testCreate(ResponseInterface $response, ?Subscription $expected, bool $expectException = false)
    {
        $sut = new SubscriptionProcess($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'create',
                ['newName']
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\SubscriptionProcess::update
     * @dataProvider updateDataProvider
     */
    public function testUpdate(ResponseInterface $response, ?bool $expected, bool $expectException = false)
    {
        $sut = new SubscriptionProcess($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'update',
                ['470370', 'newName']
            )
        );
    }

    public static function updateDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'unknown id' => [new Response(404, [], '["Kein Opt-In-Prozess mit dieser ID."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\SubscriptionProcess::redirect
     * @dataProvider redirectDataProvider
     */
    public function testRedirect(ResponseInterface $response, ?string $expected, bool $expectException = false)
    {
        $sut = new SubscriptionProcess($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'redirect',
                ['470370', 'mymail@mydomain.com']
            )
        );
    }

    public static function redirectDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '["https:\/\/klick.marketron.io\/thankyou\/p9i3z8e6ab4xx5uvzzpzd768"]'), 'https://klick.marketron.io/thankyou/p9i3z8e6ab4xx5uvzzpzd768'];
        yield 'missing or empty list id' => [new Response(404, [], '["Kein Opt-In-Prozess mit dieser ID."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\SubscriptionProcess::delete
     * @dataProvider deleteDataProvider
     */
    public function testDelete(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new SubscriptionProcess($this->getConnectionMock($response));

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
}
