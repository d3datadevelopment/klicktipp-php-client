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

namespace D3\KlicktippPhpClient\Resources;

use D3\KlicktippPhpClient\Connection;

abstract class Model
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    protected function convertDataArrayToUrlParameters(array $data): array
    {
        $urlFields = [];
        foreach (array_filter($data) as $key => $value) {
            $urlFields['fields['.$key.']'] = $value;
        }

        return $urlFields;
    }
}
