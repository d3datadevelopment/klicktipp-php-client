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

namespace D3\KlicktippPhpClient\tests\integration;

use D3\KlicktippPhpClient\Connection;
use D3\KlicktippPhpClient\tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;

/**
 * @coversNothing
 */
class IntegrationTestCase extends TestCase
{
    protected array $historyContainer = [];

    public function getConnectionMock(ResponseInterface|array $response): Connection
    {
        $mock = new MockHandler(
            is_array($response) ? $response : [$response]
        );

        $history = Middleware::history($this->historyContainer);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);
        $client = new Client(['handler' => $handlerStack]);

        $connection = new Connection('userName', 'password');
        $connection->setClient($client);

        return $connection;
    }

    protected function getHistoryContainer(): array
    {
        return $this->historyContainer;
    }
}
