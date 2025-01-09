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
use D3\KlicktippPhpClient\Resources\Tag;

/**
 * @coversNothing
 */
class TagTest extends AvailabilityTestCase
{
    /**
     * @return void
     * @throws KlicktippExceptionInterface
     */
    public function testFields(): void
    {
        $klicktipp = $this->getKlicktipp();
        $endpoint = $klicktipp->tag();
        $tagId = null;

        try {
            $tagId = $endpoint->create('testTagName');
            $this->assertNotEmpty($tagId);

            $properties = $endpoint->get($tagId);
            $this->assertArrayHasKey(Tag::NAME, $properties);
            $this->assertEquals('testTagName', $properties[Tag::NAME]);

            $fieldList = $endpoint->index();
            $this->assertArrayHasKey($tagId, $fieldList->toArray());

            $success = $endpoint->update($tagId, 'updatedTestFieldName');
            $this->assertTrue($success);

            $success = $endpoint->delete($tagId);
            $this->assertTrue($success);

        } catch (KlicktippExceptionInterface $exception) {
            if ($tagId) {
                if (!$endpoint->delete($tagId)) {
                    echo "can't delete tag with id $tagId\n";
                }
            }

            throw $exception;
        }
    }
}
