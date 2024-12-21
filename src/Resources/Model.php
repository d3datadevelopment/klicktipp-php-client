<?php

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Connection;

abstract class Model
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}
