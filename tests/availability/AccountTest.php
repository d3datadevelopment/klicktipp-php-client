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

use D3\KlicktippPhpClient\Resources\Account;

/**
 * @coversNothing
 */
class AccountTest extends AvailabilityTestCase
{
    public function testFields(): void
    {
        $klicktipp = $this->getKlicktipp();
        $endpoint = $klicktipp->account();

        $properties = $endpoint->get();
        $this->assertArrayHasKey(Account::USERNAME, $properties);
        $this->assertEquals($properties[Account::USERNAME], trim(getenv(AvailabilityTestCase::CLIENT_VAR)));

        $success = $endpoint->logout();
        $this->assertTrue($success);
    }
}
