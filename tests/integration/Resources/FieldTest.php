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

namespace D3\KlicktippPhpClient\tests\integration\Resources;

use D3\KlicktippPhpClient\Entities\FieldList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use D3\KlicktippPhpClient\Resources\Field;
use D3\KlicktippPhpClient\tests\integration\IntegrationTestCase;
use Generator;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

/**
 * @coversNothing
 */
class FieldTest extends IntegrationTestCase
{
    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Field::index
     * @dataProvider indexDataProvider
     */
    public function testIndex(ResponseInterface $response, ?FieldList $expected, bool $expectException = false)
    {
        $sut = new Field($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'index',
            )
        );
    }

    public static function indexDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "fieldFirstName": "Vorname",
            "fieldLastName": "Nachname",
            "fieldCompanyName": "Firma",
            "fieldStreet1": "Straße 1",
            "fieldStreet2": "Straße 2",
            "fieldCity": "Stadt",
            "fieldState": "Bundesland",
            "fieldZip": "Postleitzahl",
            "fieldCountry": "Land",
            "fieldPrivatePhone": "Telefon (Privat)",
            "fieldMobilePhone": "Telefon (Mobil)",
            "fieldPhone": "Telefon",
            "fieldFax": "Fax",
            "fieldWebsite": "Website",
            "fieldBirthday": "Geburtstag",
            "fieldLeadValue": "LeadValue"
        }'), new FieldList([
            "fieldFirstName"    => "Vorname",
            "fieldLastName"     => "Nachname",
            "fieldCompanyName"  => "Firma",
            "fieldStreet1"      => "Straße 1",
            "fieldStreet2"      => "Straße 2",
            "fieldCity"         => "Stadt",
            "fieldState"        => "Bundesland",
            "fieldZip"          => "Postleitzahl",
            "fieldCountry"      => "Land",
            "fieldPrivatePhone" => "Telefon (Privat)",
            "fieldMobilePhone"  => "Telefon (Mobil)",
            "fieldPhone"        => "Telefon",
            "fieldFax"          => "Fax",
            "fieldWebsite"      => "Website",
            "fieldBirthday"     => "Geburtstag",
            "fieldLeadValue"    => "LeadValue",
        ])];
        yield 'wrong request type' => [new Response(406, [], '["Bei der Erstellung des Objekt ist ein Fehler aufgetreten."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }
}
