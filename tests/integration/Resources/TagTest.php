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

use D3\KlicktippPhpClient\Entities\Tag as TagEntity;
use D3\KlicktippPhpClient\Entities\TagList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use D3\KlicktippPhpClient\Resources\Tag;
use D3\KlicktippPhpClient\tests\integration\IntegrationTestCase;
use Generator;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

/**
 * @coversNothing
 */
class TagTest extends IntegrationTestCase
{
    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Tag::index
     * @dataProvider indexDataProvider
     */
    public function testIndex(ResponseInterface $response, ?TagList $expected, bool $expectException = false)
    {
        $sut = new Tag($this->getConnectionMock($response));

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
            "12514414": "tagName2",
            "12514413": "tagName"
        }'), new TagList([
            "12514414"    => "tagName2",
            "12514413"     => "tagName",
        ])];
        yield 'wrong request type' => [new Response(405, [], '"No route found for \"DELETE https:\/\/api-internal.klicktipp.com\/api\/tag.json\": Method Not Allowed (Allow: GET, POST)"'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Tag::get
     * @dataProvider getDataProvider
     */
    public function testGet(ResponseInterface $response, ?TagEntity $expected, bool $expectException = false)
    {
        $sut = new Tag($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'get',
                ['12514414']
            )
        );
    }

    public static function getDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "tagid": "12514414",
            "name": "tagName2",
            "text": ""
        }'), new TagEntity([
            "tagid"    => "12514414",
            "name" => "tagName2",
            "text" => "",
        ])];
        yield 'unknown id' => [new Response(404, [], '["Kein Tag mit dieser ID."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Tag::create
     * @dataProvider createDataProvider
     */
    public function testCreate(ResponseInterface $response, ?string $expected, bool $expectException = false)
    {
        $sut = new Tag($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'create',
                ['newTagName']
            )
        );
    }

    public static function createDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[12494414]'), '12494414'];
        yield 'missing or empty tag name' => [new Response(406, [], '["Tag konnte nicht erstellt werden."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Tag::update
     * @dataProvider updateDataProvider
     */
    public function testUpdate(ResponseInterface $response, ?bool $expected, bool $expectException = false)
    {
        $sut = new Tag($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'update',
                ['12494414', 'tagName']
            )
        );
    }

    public static function updateDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'unknown tag' => [new Response(404, [], '["Kein Tag mit dieser ID."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Tag::delete
     * @dataProvider deleteDataProvider
     */
    public function testDelete(ResponseInterface $response, ?bool $expected, bool $expectException = false)
    {
        $sut = new Tag($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'delete',
                ['12494414']
            )
        );
    }

    public static function deleteDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'unknown tag' => [new Response(404, [], '["Kein Tag mit dieser ID."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }
}
