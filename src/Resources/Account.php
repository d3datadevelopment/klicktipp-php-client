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

use D3\KlicktippPhpClient\Exceptions\BaseException;
use GuzzleHttp\RequestOptions;

class Account extends Model
{
    /**
     * @throws BaseException
     */
    public function login(): array
    {
        return $this->connection->requestAndParse(
            'POST',
            'account/login.json',
            [
                RequestOptions::FORM_PARAMS => [
                    'username' => $this->connection->getClientKey(),
                    'password' => $this->connection->getSecretKey(),
                ],
            ]
        );
    }

    /**
     * @throws BaseException
     */
    public function logout(): bool
    {
        $response = $this->connection->requestAndParse(
            'POST',
            'account/logout.json'
        );

        return (bool)current($response);
    }
}
