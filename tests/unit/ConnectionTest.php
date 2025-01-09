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
use D3\KlicktippPhpClient\Exceptions\CommunicationException;
use D3\KlicktippPhpClient\Exceptions\NoCredentialsException;
use D3\KlicktippPhpClient\Exceptions\ResponseContentException;
use D3\KlicktippPhpClient\tests\TestCase;
use Exception;
use Generator;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

/**
 * @covers \D3\KlicktippPhpClient\Connection
 */
class ConnectionTest extends TestCase
{
    /**
     * @test
     * @covers       \D3\KlicktippPhpClient\Connection::__construct
     * @covers       \D3\KlicktippPhpClient\Connection::getClientKey
     * @covers       \D3\KlicktippPhpClient\Connection::getSecretKey
     * @covers       \D3\KlicktippPhpClient\Connection::getCookiesJar
     * @dataProvider constructDataProvider
     */
    public function testConstruct(string $userName, string $password, bool $expectException): void
    {
        if ($expectException) {
            $this->expectException(NoCredentialsException::class);
        }

        $sut = new Connection($userName, $password);

        $this->assertSame(
            $userName,
            $sut->getClientKey()
        );
        $this->assertSame(
            $password,
            $sut->getSecretKey()
        );
        $this->assertInstanceOf(
            CookieJar::class,
            $sut->getCookiesJar()
        );
    }

    public static function constructDataProvider(): Generator
    {
        yield 'all credentials set' => ['myuser', 'mypassword', false];
        yield 'missing username' => ['', 'mypassword', true];
        yield 'missing password' => ['myuser', '', true];
        yield 'no credentials given' => ['', '', true];
    }

    /**
     * @test
     * @return void
     * @covers \D3\KlicktippPhpClient\Connection::setClient
     * @covers \D3\KlicktippPhpClient\Connection::getClient
     */
    public function testSetClient(): void
    {
        $clientMock = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([])
            ->getMock();

        $sut = new Connection('foo', 'bar');
        $sut->setClient($clientMock);

        $this->assertSame(
            $clientMock,
            $sut->getClient()
        );
    }

    /**
     * @test
     * @return void
     * @covers \D3\KlicktippPhpClient\Connection::getClient
     */
    public function testGetUnconfiguredClient(): void
    {
        $sut = new Connection('foo', 'bar');

        $this->assertInstanceOf(
            ClientInterface::class,
            $sut->getClient()
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Connection::request
     * @dataProvider requestDataProvider
     */
    public function testRequest(?Exception $thrownException, ?string $expectedException): void
    {
        $responseMock = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->onlyMethods(get_class_methods(Response::class))
            ->getMock();

        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['request'])
            ->getMock();
        $clientMock->expects($this->once())->method('request')->will(
            $thrownException ?
                $this->throwException($thrownException) :
                $this->returnValue($responseMock)
        );

        $sutMock = $this->getMockBuilder(Connection::class)
            ->setConstructorArgs(['foo', 'bar'])
            ->onlyMethods(['getClient', 'getCookiesJar', 'parseResponse'])
            ->getMock();
        $sutMock->method('getClient')->willReturn($clientMock);

        if ($expectedException) {
            $this->expectException($expectedException);
        }

        $this->assertInstanceOf(
            ResponseInterface::class,
            $this->callMethod(
                $sutMock,
                'request',
                ['POST', 'fixture.php', ['body' => 'requBody']]
            )
        );
    }

    public static function requestDataProvider(): Generator
    {
        yield 'passed'  => [null, null];
        yield 'request exception'  => [
            new RequestException(
                'foo',
                new \GuzzleHttp\Psr7\Request('POST', 'fixture.php'),
                new Response(200, [], 'respBody')
            ), CommunicationException::class];
        yield 'guzzle exception'  => [
            new ConnectException(
                'foo',
                new \GuzzleHttp\Psr7\Request('POST', 'fixture.php')
            ), CommunicationException::class];
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Connection::requestAndParse
     */
    public function testRequestAndParse(): void
    {
        $expected = ['foo' => 'bar'];

        $responseMock = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->getMock();

        $sutMock = $this->getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['request', 'parseResponse'])
            ->getMock();
        $sutMock->expects($this->once())->method('request')->willReturn($responseMock);
        $sutMock->expects($this->once())->method('parseResponse')->willReturn($expected);

        $this->assertSame(
            $expected,
            $this->callMethod(
                $sutMock,
                'requestAndParse',
                ['POST', 'endpoint.php', ['options' => '']]
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Connection::parseResponse
     * @dataProvider parseResponseDataProvider
     */
    public function testParseResponse(int $status, $content, $expected, bool $expectException): void
    {
        $sut = new Connection('foo', 'bar');

        $responseBodyMock = $this->getMockBuilder(Stream::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getContents'])
            ->getMock();
        $responseBodyMock->method('getContents')->willReturn(json_encode($content));

        $responseMock = $this->getMockBuilder(Response::class)
            ->setConstructorArgs([$status, [], $content])
            ->onlyMethods(['getStatusCode'])
            ->getMock();
        $responseMock->method('getStatusCode')->willReturn($status);

        if ($expectException) {
            $this->expectException(ResponseContentException::class);
        }

        $this->assertSame(
            $expected,
            $this->callMethod(
                $sut,
                'parseResponse',
                [$responseMock]
            )
        );
    }

    public static function parseResponseDataProvider(): Generator
    {
        yield '200' => [200, '{"foo": "bar"}', ['foo' => 'bar'], false];
        yield '204' => [204, '{"foo": "bar"}', [], false];
        yield 'no array return' => [200, '"foo"', [], true];
    }
}
