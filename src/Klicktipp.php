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

namespace D3\KlicktippPhpClient;

use D3\KlicktippPhpClient\Exceptions\CommunicationException;
use D3\KlicktippPhpClient\Resources\Account;
use D3\KlicktippPhpClient\Resources\Field;
use D3\KlicktippPhpClient\Resources\Subscriber;
use D3\KlicktippPhpClient\Resources\SubscriptionProcess;
use D3\KlicktippPhpClient\Resources\Tag;
use GuzzleHttp\ClientInterface;

class Klicktipp
{
    protected ?Connection $connection = null;

    /**
     * @throws CommunicationException
     */
    public function __construct(
        protected string $client_key,
        protected string $secret_key,
        ClientInterface $client = null
    ) {
        if ($client) {
            $this->getConnection()->setClient($client);
        }

        $this->account()->login();
    }

    protected function getConnection(): Connection
    {
        if (!$this->connection) {
            $this->connection = new Connection($this->client_key, $this->secret_key);
        }
        return $this->connection;
    }

    public function subscription(): SubscriptionProcess
    {
        return new SubscriptionProcess($this->getConnection());
    }

    public function account(): Account
    {
        return new Account($this->getConnection());
    }

    public function field(): Field
    {
        return new Field($this->getConnection());
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
