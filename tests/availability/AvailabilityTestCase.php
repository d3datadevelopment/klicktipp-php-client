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

namespace D3\KlicktippPhpClient\tests\availability;

use D3\KlicktippPhpClient\Connection;
use D3\KlicktippPhpClient\Klicktipp;
use D3\KlicktippPhpClient\tests\TestCase;

/**
 * @coversNothing
 */
abstract class AvailabilityTestCase extends TestCase
{
    public const CLIENT_VAR = 'KLICKTIPP_CLIENT_ENV';
    public const SECRET_VAR = 'KLICKTIPP_SECRET_ENV';

    public function setUp(): void
    {
        if (!strlen((string) getenv('KLICKTIPP_CLIENT_ENV')) || !strlen((string) getenv('KLICKTIPP_SECRET_ENV'))) {
            fwrite(STDOUT, 'Insert your client key / username: ');
            $clientKey = fgets(STDIN);
            putenv(self::CLIENT_VAR.'=' . $clientKey);
            fwrite(STDOUT, 'Enter your secret / password: ');
            $secretKey = fgets(STDIN);
            putenv(self::SECRET_VAR.'=' . $secretKey);
        }

        parent::setUp();
    }

    protected function getKlicktipp(): Klicktipp
    {
        return new Klicktipp(
            getenv(self::CLIENT_VAR),
            getenv(self::SECRET_VAR)
        );
    }
}
