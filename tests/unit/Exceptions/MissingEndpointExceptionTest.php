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

namespace D3\KlicktippPhpClient\tests\unit\Exceptions;

use D3\KlicktippPhpClient\Exceptions\CommunicationException;
use D3\KlicktippPhpClient\Exceptions\MissingEndpointException;
use D3\KlicktippPhpClient\tests\TestCase;
use ReflectionException;

/**
 * @covers \D3\KlicktippPhpClient\Exceptions\MissingEndpointException
 */
class MissingEndpointExceptionTest extends TestCase
{
    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Exceptions\MissingEndpointException::__construct
     */
    public function testConstructor(): void
    {
        /** @var MissingEndpointException $sutMock */
        $sutMock = $this->getMockBuilder(MissingEndpointException::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->callMethod(
            $sutMock,
            '__construct',
            ['myMessage', []]
        );

        $this->assertMatchesRegularExpression(
            '/.*?endpoint.*?missing.*/i',
            $sutMock->getMessage()
        );
    }
}
