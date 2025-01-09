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

use D3\KlicktippPhpClient\Exceptions\KlicktippExceptionInterface;
use D3\KlicktippPhpClient\Resources\Field;
use PHPUnit\Exception;

/**
 * @coversNothing
 */
class FieldTest extends AvailabilityTestCase
{
    public function testFields(): void
    {
        $klicktipp = $this->getKlicktipp();
        $endpoint = $klicktipp->field();
        $fieldId = null;

        try {
            $fieldId = $endpoint->create('testFieldName');
            $this->assertNotEmpty($fieldId);

            $properties = $endpoint->get($fieldId);
            $this->assertArrayHasKey(Field::NAME, $properties);
            $this->assertEquals($properties[Field::NAME], 'testFieldName');

            $fieldList = $endpoint->index();
            $this->assertArrayHasKey('field'.$fieldId, $fieldList->toArray());

            $success = $endpoint->update($fieldId, 'updatedTestFieldName');
            $this->assertTrue($success);

            $success = $endpoint->delete($fieldId);
            $this->assertTrue($success);

        } catch (KlicktippExceptionInterface|Exception $exception) {
            if ($fieldId) {
                if (!$endpoint->delete($fieldId)) {
                    echo "can't delete field with id $fieldId\n";
                };
            }

            throw $exception;
        } finally {
            $klicktipp->account()->logout();
        }
    }
}
