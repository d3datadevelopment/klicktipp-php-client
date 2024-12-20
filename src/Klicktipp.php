<?php

/**
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <info@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

declare(strict_types=1);

namespace D3\KlicktippPhpClient;

use D3\KlicktippPhpClient\Exceptions\BaseException;
use D3\KlicktippPhpClient\Resources\Account;
use D3\KlicktippPhpClient\Resources\Subscriber;
use D3\KlicktippPhpClient\Resources\Tag;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class Klicktipp
{
    protected string $client_key;

    protected string $secret_key;

    protected ?Connection $connection = null;

    /**
     * @throws BaseException
     * @throws GuzzleException
     */
    public function __construct(
        string $client_key,
        string $secret_key,
        ClientInterface $client = null
    ){
        $this->client_key = $client_key;
        $this->secret_key = $secret_key;

        if ($client) {
            $this->getConnection()->setClient($client);
        }

        $this->account()->login();
    }

    private function getConnection(): Connection
    {
        if (!$this->connection) {
            $this->connection = new Connection($this->client_key, $this->secret_key);
        }
        return $this->connection;
    }

    public function account(): Account
    {
        return new Account($this->getConnection());
    }

    public function subscriber(): Subscriber
    {
        return new Subscriber($this->getConnection());
    }

    public function tag(): Tag
    {
        return new Tag($this->getConnection());
    }
}
