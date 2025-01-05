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

namespace D3\KlicktippPhpClient\tests\integration\Resources;

use D3\KlicktippPhpClient\Entities\Field as FieldEntity;
use D3\KlicktippPhpClient\Entities\FieldList;
use D3\KlicktippPhpClient\Exceptions\BaseException;
use D3\KlicktippPhpClient\Resources\Field;
use D3\KlicktippPhpClient\Resources\Subscriber;
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
    public function testIndex(ResponseInterface $response, ?FieldList $expected, bool $expectException = false): void
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
            "'.Subscriber::FIELD_FIRSTNAME.'": "Vorname",
            "'.Subscriber::FIELD_LASTNAME.'": "Nachname",
            "'.Subscriber::FIELD_COMPANYNAME.'": "Firma",
            "'.Subscriber::FIELD_STREET1.'": "Straße 1",
            "'.Subscriber::FIELD_STREET2.'": "Straße 2",
            "'.Subscriber::FIELD_CITY.'": "Stadt",
            "'.Subscriber::FIELD_STATE.'": "Bundesland",
            "'.Subscriber::FIELD_ZIP.'": "Postleitzahl",
            "'.Subscriber::FIELD_COUNTRY.'": "Land",
            "'.Subscriber::FIELD_PRIVATEPHONE.'": "Telefon (Privat)",
            "'.Subscriber::FIELD_MOBILEPHONE.'": "Telefon (Mobil)",
            "'.Subscriber::FIELD_PHONE.'": "Telefon",
            "'.Subscriber::FIELD_FAX.'": "Fax",
            "'.Subscriber::FIELD_WEBSITE.'": "Website",
            "'.Subscriber::FIELD_BIRTHDAY.'": "Geburtstag",
            "'.Subscriber::FIELD_LEADVALUE.'": "LeadValue"
        }'), new FieldList([
            Subscriber::FIELD_FIRSTNAME    => "Vorname",
            Subscriber::FIELD_LASTNAME     => "Nachname",
            Subscriber::FIELD_COMPANYNAME  => "Firma",
            Subscriber::FIELD_STREET1      => "Straße 1",
            Subscriber::FIELD_STREET2      => "Straße 2",
            Subscriber::FIELD_CITY         => "Stadt",
            Subscriber::FIELD_STATE        => "Bundesland",
            Subscriber::FIELD_ZIP          => "Postleitzahl",
            Subscriber::FIELD_COUNTRY      => "Land",
            Subscriber::FIELD_PRIVATEPHONE => "Telefon (Privat)",
            Subscriber::FIELD_MOBILEPHONE  => "Telefon (Mobil)",
            Subscriber::FIELD_PHONE        => "Telefon",
            Subscriber::FIELD_FAX          => "Fax",
            Subscriber::FIELD_WEBSITE      => "Website",
            Subscriber::FIELD_BIRTHDAY     => "Geburtstag",
            Subscriber::FIELD_LEADVALUE    => "LeadValue",
        ])];
        yield 'wrong request type' => [new Response(406, [], '["Bei der Erstellung des Objekt ist ein Fehler aufgetreten."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Field::get
     * @covers \D3\KlicktippPhpClient\Resources\Field::getEntity
     * @dataProvider getDataProvider
     */
    public function testGet(ResponseInterface $response, ?array $expected, bool $expectException = false): void
    {
        $sut = new Field($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $return = $this->callMethod(
            $sut,
            'getEntity',
            ['12514414']
        );

        $this->assertInstanceOf(FieldEntity::class, $return);
        $this->assertSame($expected, $return->toArray());
    }

    public static function getDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '{
            "'.Field::ID.'": "12514414",
            "'.Field::NAME.'": "fieldName2"
        }'), [
            Field::ID    => "12514414",
            Field::NAME => "fieldName2",
        ]];
        yield 'unknown id' => [new Response(404, [], '["Kein Field mit dieser ID."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Field::create
     * @dataProvider createDataProvider
     */
    public function testCreate(ResponseInterface $response, ?string $expected, bool $expectException = false): void
    {
        $sut = new Field($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'create',
                ['newFieldName']
            )
        );
    }

    public static function createDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[12494414]'), '12494414'];
        yield 'missing or empty field name' => [new Response(406, [], '["Field konnte nicht erstellt werden."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Field::update
     * @dataProvider updateDataProvider
     */
    public function testUpdate(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new Field($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'update',
                ['12494414', 'fieldName']
            )
        );
    }

    public static function updateDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'unknown field' => [new Response(404, [], '["Kein Tag mit dieser ID."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Resources\Field::delete
     * @dataProvider deleteDataProvider
     */
    public function testDelete(ResponseInterface $response, ?bool $expected, bool $expectException = false): void
    {
        $sut = new Field($this->getConnectionMock($response));

        if ($expectException) {
            $this->expectException(BaseException::class);
        }

        $this->assertEquals(
            $expected,
            $this->callMethod(
                $sut,
                'delete',
                ['12494414']
            )
        );
    }

    public static function deleteDataProvider(): Generator
    {
        yield 'success' => [new Response(200, [], '[true]'), true];
        yield 'unknown field' => [new Response(404, [], '["Kein Field mit dieser ID."]'), null, true];
        yield 'access denied' => [new Response(403, [], '["API Zugriff verweigert"]'), null, true];
    }
}
