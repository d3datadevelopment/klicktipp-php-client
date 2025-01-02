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

namespace D3\KlicktippPhpClient\tests\unit\Entities;

use D3\KlicktippPhpClient\Entities\Subscriber;
use D3\KlicktippPhpClient\tests\TestCase;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Generator;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use ReflectionException;

/**
 * @coversNothing
 */
class SubscriberTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->entity = new Subscriber(
            [
                "id"    => "155988456",
                "listid" => "368370",
                "optin" => "28.12.2024 22:52:09",
                "optin_ip" => "0.0.0.0 - By API Request",
                "email" => "testsubscriber@mydomain.com",
                "status" => "Opt-In Pending",
                "bounce" => "Not Bounced",
                "date" => "2024-12-24",
                "ip" => "0.0.0.0 - By API Request",
                "unsubscription" => "unsubscription fixture",
                "unsubscription_ip" => "0.0.0.0",
                "referrer" => "referrer fixture",
                "sms_phone" => "1234567890",
                "sms_status" => "sms status fixture",
                "sms_bounce" => "sms bounce fixture",
                "sms_date" => "2024-12-23",
                "sms_unsubscription" => "sms unsubscription fixture",
                "sms_referrer" => "sms referrer fixture",
                "fieldFirstName" =>  "",
                "fieldLastName" => "",
                "fieldCompanyName" => "",
                "fieldStreet1" => "",
                "fieldStreet2" =>  "",
                "fieldCity" => "",
                "fieldState" =>  "",
                "fieldZip" => "",
                "fieldCountry" => "",
                "fieldPrivatePhone" => "",
                "fieldMobilePhone" => "",
                "fieldPhone" => "",
                "fieldFax" => "",
                "fieldWebsite" => "",
                "fieldBirthday" => "",
                "fieldLeadValue" => "",
                "tags"  => [
                    "12494453",
                    "12494463",
                ],
                "manual_tags"  => [
                    "12594453"  => "125959453",
                    "12594454"  => "125960453",
                    "12594455"  => "125961453",
                ],
                "smart_tags"  => [
                    "12594456"  => "125959453",
                    "12594457"  => "125960453",
                    "12594458"  => "125961453",
                    "12594459"  => "125961453",
                ],
                "campaigns_started"  => [
                    "12594456"  => "125959453",
                ],
                "campaigns_finished"  => [
                    "12594456"  => "125959453",
                    "12594457"  => "125959453",
                ],
                "notification_emails_sent"  => [
                    "1570256"   => "1730508478",
                    "1570257"   => "1730508479",
                    "1570258"   => "1730508480",
                ],
                "notification_emails_opened"  => [
                    "1570256"   => "1730508478",
                    "1570257"   => "1730508479",
                    "1570258"   => "1730508480",
                    "1570259"   => "1730508481",
                ],
                "notification_emails_clicked"  => [
                    "1570256"   => "1730508478",
                    "1570257"   => "1730508479",
                    "1570258"   => "1730508480",
                    "1570259"   => "1730508481",
                    "1570260"   => "1730508482",
                ],
                "notification_emails_viewed"  => [
                    "1570256"   => "1730508478",
                    "1570257"   => "1730508479",
                    "1570258"   => "1730508480",
                    "1570259"   => "1730508481",
                    "1570260"   => "1730508482",
                    "1570261"   => "1730508483",
                ],
                "outbound"  => [
                    "1570256"   => "1730508478",
                ],
            ]
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::__construct
     */
    public function testConstruct(): void
    {
        $elements = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $endpoint = $this->getMockBuilder(\D3\KlicktippPhpClient\Resources\Subscriber::class)
            ->disableOriginalConstructor()
            ->getMock();

        $sut = new Subscriber($elements, $endpoint);

        $this->assertSame(
            $elements,
            $sut->toArray()
        );
        $this->assertSame(
            $endpoint,
            $this->getValue($sut, 'endpoint')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getId
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getListId
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getOptinIp
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getEmailAddress
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getStatus
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getBounce
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getIp
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getUnsubscriptionIp
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getReferrer
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getSmsPhone
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getSmsStatus
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getSmsBounce
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getSmsReferrer
     * @dataProvider getSomethingDataProvider
     */
    public function testGetSomething(string $methodName, string $expectedValue)
    {
        $this->assertSame(
            $expectedValue,
            $this->callMethod($this->entity, $methodName)
        );
    }

    public static function getSomethingDataProvider(): Generator
    {
        yield ['getId', '155988456'];
        yield ['getListId', '368370'];
        yield ['getOptinIp', '0.0.0.0 - By API Request'];
        yield ['getEmailAddress', 'testsubscriber@mydomain.com'];
        yield ['getStatus', 'Opt-In Pending'];
        yield ['getBounce', 'Not Bounced'];
        yield ['getIp', '0.0.0.0 - By API Request'];
        yield ['getUnsubscriptionIp', '0.0.0.0'];
        yield ['getReferrer', 'referrer fixture'];
        yield ['getSmsPhone', '1234567890'];
        yield ['getSmsStatus', 'sms status fixture'];
        yield ['getSmsBounce', 'sms bounce fixture'];
        yield ['getSmsReferrer', 'sms referrer fixture'];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getOptinTime
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getDate
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getUnsubscription
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getSmsDate
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getSmsUnsubscription
     * @dataProvider getTimesDataProvider
     */
    public function testGetTimes($methodName): void
    {
        $sut = $this->getMockBuilder(Subscriber::class)
            ->onlyMethods(['getDateTimeFromValue'])
            ->getMock();
        $sut->expects($this->once())->method('getDateTimeFromValue');

        $this->callMethod($sut, $methodName);
    }

    public static function getTimesDataProvider(): Generator
    {
        yield ['getOptinTime'];
        yield ['getDate'];
        yield ['getUnsubscription'];
        yield ['getSmsDate'];
        yield ['getSmsUnsubscription'];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getDateTimeFromValue
     * @dataProvider getDateTimeFromValueDataProvider
     */
    public function testGetDateTimeFromValue(?string $value, ?DateTime $expectedValue): void
    {
        $this->assertEquals(
            $expectedValue,
            $this->callMethod(
                $this->entity,
                'getDateTimeFromValue',
                [$value]
            )
        );
    }

    public static function getDateTimeFromValueDataProvider(): Generator
    {
        yield 'null'    => [null, null];
        yield 'valid date'    => ['2024-12-24', new DateTime('2024-12-24')];
        yield 'valid date time'    => ['28.12.2024 22:52:09', new DateTime('2024-12-28 22:52:09')];
        yield 'invalid'    => ['', null];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::isOptedIn
     * @dataProvider isOptedinDataProvider
     */
    public function testIsOptedIn(?DateTime $optinTime, bool $expected): void
    {
        $sut = $this->getMockBuilder(Subscriber::class)
            ->onlyMethods(['getOptinTime'])
            ->getMock();
        $sut->method('getOptinTime')->willReturn($optinTime);

        $this->assertSame(
            $expected,
            $this->callMethod($sut, 'isOptedIn')
        );
    }

    public static function isOptedinDataProvider(): Generator
    {
        yield 'null'    => [null, false];
        yield 'zero date'    => [new DateTime('0000-00-00'), false];
        yield 'in past'    => [new DateTime('1980-12-24'), true];
        yield 'in future'    => [new DateTime('2040-12-24'), false];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::isSubscribed
     * @dataProvider isSubscribedDataProvider
     */
    public function testIsSubscribed(?string $status, bool $expected): void
    {
        $sut = $this->getMockBuilder(Subscriber::class)
            ->onlyMethods(['getStatus'])
            ->getMock();
        $sut->method('getStatus')->willReturn($status);

        $this->assertSame(
            $expected,
            $this->callMethod($sut, 'isSubscribed')
        );
    }

    public static function isSubscribedDataProvider(): Generator
    {
        yield 'null'    => [null, false];
        yield 'empty term'    => ['', false];
        yield 'wrong term'    => ['fixture', false];
        yield 'right term'    => [Subscriber::STATUS_SUBSCRIBED, true];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::isBounced
     * @dataProvider isBouncedDataProvider
     */
    public function testIsBounced(?string $status, bool $expected): void
    {
        $sut = $this->getMockBuilder(Subscriber::class)
            ->onlyMethods(['getBounce'])
            ->getMock();
        $sut->method('getBounce')->willReturn($status);

        $this->assertSame(
            $expected,
            $this->callMethod($sut, 'isBounced')
        );
    }

    public static function isBouncedDataProvider(): Generator
    {
        yield 'null'    => [null, true];
        yield 'empty term'    => ['', true];
        yield 'right term'    => ['fixture', true];
        yield 'wrong term'    => [Subscriber::BOUNCE_NOTBOUNCED, false];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::changeEmailAddress
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::setSmsPhone
     * @dataProvider changeEmailAddressDataProvider
     */
    public function testChangeEmailAddress(
        string $testMethodName,
        string $fieldName
    ): void {
        $sut = $this->getMockBuilder(Subscriber::class)
            ->onlyMethods(['set'])
            ->setConstructorArgs([['id' => 'foo']])
            ->getMock();
        $sut->expects($this->once())->method('set')->with(
            $this->identicalTo($fieldName)
        );

        $this->callMethod(
            $sut,
            $testMethodName,
            ['newValue']
        );
    }

    public static function changeEmailAddressDataProvider(): Generator
    {
        yield 'change email has endpoint'    => ['changeEmailAddress', 'email'];
        yield 'change email has no endpoint'    => ['changeEmailAddress', 'email'];
        yield 'set phone has endpoint'    => ['setSmsPhone', 'sms_phone'];
        yield 'set phone has no endpoint'    => ['setSmsPhone', 'sms_phone'];
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getFields
     */
    public function testGetFields()
    {
        $fields = $this->callMethod(
            $this->entity,
            'getFields',
        );

        $this->assertInstanceOf(ArrayCollection::class, $fields);
        $this->assertCount(16, $fields);
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getField
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getFieldLongName
     * @dataProvider getFieldDataProvider
     */
    public function testGetField(string $fieldName, string $expectedFieldName): void
    {
        $arrayCollectionMock = $this->getMockBuilder(ArrayCollection::class)
            ->onlyMethods(['get'])
            ->getMock();
        $arrayCollectionMock->expects($this->once())->method('get')->with(
            $this->identicalTo($expectedFieldName)
        )->willReturn('expected');

        $sut = $this->getMockBuilder(Subscriber::class)
            ->onlyMethods(['getFields'])
            ->getMock();
        $sut->method('getFields')->willReturn($arrayCollectionMock);

        $this->assertSame(
            'expected',
            $this->callMethod(
                $sut,
                'getField',
                [$fieldName]
            )
        );
    }

    public static function getFieldDataProvider(): Generator
    {
        yield 'short field name'    => ['FirstName', 'fieldFirstName'];
        yield 'long field name'    => ['fieldLastName', 'fieldLastName'];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::setField
     * @dataProvider setFieldDataProvider
     */
    public function testSetField(
        string $fieldName,
        string $longFieldName
    ): void {
        $sut = $this->getMockBuilder(Subscriber::class)
            ->onlyMethods(['set'])
            ->setConstructorArgs([['id' => 'foo']])
            ->getMock();
        $sut->expects($this->once())->method('set')->with(
            $this->identicalTo($longFieldName)
        );

        $this->callMethod(
            $sut,
            'setField',
            [$fieldName, 'newValue']
        );
    }

    public static function setFieldDataProvider(): Generator
    {
        yield 'short field name'    => ['FirstName', 'fieldFirstName'];
        yield 'long field name'    => ['fieldLastName', 'fieldLastName'];
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getTags
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getManualTags
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getSmartTags
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getStartedCampaigns
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getFinishedCampaigns
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getSentNotificationEmails
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getOpenedNotificationEmails
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getClickedNotificationEmails
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getViewedNotificationEmails
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getOutbounds
     * @dataProvider getTagsDataProvider
     */
    public function testGetTags(string $methodName, int $expectedCount)
    {
        $tags = $this->callMethod(
            $this->entity,
            $methodName,
        );

        $this->assertInstanceOf(ArrayCollection::class, $tags);
        $this->assertCount($expectedCount, $tags);
    }

    public static function getTagsDataProvider(): Generator
    {
        yield ['getTags', 2];
        yield ['getManualTags', 3];
        yield ['getSmartTags', 4];
        yield ['getStartedCampaigns', 1];
        yield ['getFinishedCampaigns', 2];
        yield ['getSentNotificationEmails', 3];
        yield ['getOpenedNotificationEmails', 4];
        yield ['getClickedNotificationEmails', 5];
        yield ['getViewedNotificationEmails', 6];
        yield ['getOutbounds', 1];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::isTagSet
     * @dataProvider isTagSetDataProvider
     */
    public function testIsTagSet(string $searchTagId, bool $expected)
    {
        $tagList = new ArrayCollection([
            "12494453",
            "12494463",
        ]);

        $sut = $this->getMockBuilder(Subscriber::class)
            ->onlyMethods(['getTags'])
            ->getMock();
        $sut->method('getTags')->willReturn($tagList);

        $this->assertSame(
            $expected,
            $this->callMethod(
                $sut,
                'isTagSet',
                [$searchTagId]
            )
        );
    }

    public static function isTagSetDataProvider(): Generator
    {
        yield 'existing tag' => ['12494463', true];
        yield 'missing tag' => ['12495463', false];
    }

    /**
     * @test
     * @return void
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::clearTags
     * @throws ReflectionException
     */
    public function testClearTags(): void
    {
        $this->callMethod(
            $this->entity,
            'clearTags'
        );

        $this->assertCount(0, $this->callMethod($this->entity, 'getTags'));
    }

    /**
     * @test
     * @return void
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::addTag
     * @throws ReflectionException
     */
    public function testAddTag(): void
    {
        $this->callMethod(
            $this->entity,
            'addTag',
            ['78546214']
        );

        $this->assertCount(3, $this->callMethod($this->entity, 'getTags'));
        $this->assertContains('78546214', $this->callMethod($this->entity, 'getTags'));
    }

    /**
     * @test
     * @return void
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::removeTag
     * @throws ReflectionException
     */
    public function testRemoveTag(): void
    {
        $this->callMethod(
            $this->entity,
            'removeTag',
            ['12494453']
        );

        $this->assertCount(1, $this->callMethod($this->entity, 'getTags'));
        $this->assertContains('12494463', $this->callMethod($this->entity, 'getTags'));
        $this->assertNotContains('12494453', $this->callMethod($this->entity, 'getTags'));
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::persist
     * @dataProvider persistDataProvider
     */
    public function testPersist(
        bool $endpointSet,
        InvokedCount $endpointInvocation,
        ?bool $expectedReturn
    ): void {
        $endpointMock = $this->getMockBuilder(\D3\KlicktippPhpClient\Resources\Subscriber::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['update'])
            ->getMock();
        $endpointMock->expects($endpointInvocation)->method('update')->willReturn(true);

        $sut = $this->getMockBuilder(Subscriber::class)
            ->setConstructorArgs([['id' => 'foo'], $endpointSet ? $endpointMock : null])
            ->onlyMethods(['persistTags'])
            ->getMock();
        $sut->expects($this->once())->method('persistTags');

        $this->assertSame(
            $expectedReturn,
            $this->callMethod(
                $sut,
                'persist'
            )
        );
    }

    public static function persistDataProvider(): Generator
    {
        yield 'has endpoint'    => [true, self::once(), true];
        yield 'has no endpoint'    => [false, self::never(), null];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::persistTags
     * @dataProvider persistTagsDataProvider
     */
    public function testPersistTags(
        bool $endpointSet,
        InvokedCount $endpointInvocation,
        ?array $newTagList,
        InvokedCount $removeTagInvocation,
        InvokedCount $setTagInvocation
    )
    {
        $entityMock = $this->getMockBuilder(Subscriber::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getTags'])
            ->getMock();
        $entityMock->method('getTags')->willReturn(new ArrayCollection([
            "12494453",
            "12494463",
        ]));

        $endpointMock = $this->getMockBuilder(\D3\KlicktippPhpClient\Resources\Subscriber::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['get', 'tag', 'untag'])
            ->getMock();
        $endpointMock->expects($endpointInvocation)->method('get')->willReturn($entityMock);
        $endpointMock->expects($setTagInvocation)->method('tag')->willReturn(true);
        $endpointMock->expects($removeTagInvocation)->method('untag')->willReturn(true);

        $sut = new Subscriber(['id' => 'foo', 'email' => 'mymail@mydomain.tld'], $endpointSet ? $endpointMock : null);
        if ($newTagList) $sut->set('tags', $newTagList);

        $this->callMethod(
            $sut,
            'persistTags'
        );
    }

    public static function persistTagsDataProvider(): Generator
    {
        yield 'has endpoint, tag removed' => [true, self::once(), ["12494453"], self::once(), self::never()];
        yield 'has endpoint, tag added' => [true, self::once(), ["12494453","12494463","12494464"], self::never(), self::once()];
        yield 'has endpoint, taglist equals' => [true, self::once(), ["12494453","12494463"], self::never(), self::never()];
        yield 'has no endpoint'    => [false, self::never(), null, self::never(), self::never()];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::isManualTagSet
     * @dataProvider isManualTagSetDataProvider
     */
    public function testIsManualTagSet(string $searchTagId, bool $expected)
    {
        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->entity,
                'isManualTagSet',
                [$searchTagId]
            )
        );
    }

    public static function isManualTagSetDataProvider(): Generator
    {
        yield 'existing tag' => ['12594453', true];
        yield 'missing tag' => ['12605453', false];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getManualTagTime
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getSmartTagTime
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getStartedCampaignTime
     * @covers \D3\KlicktippPhpClient\Entities\Subscriber::getFinishedCampaignTime
     * @dataProvider getTagDataProvider
     */
    public function testGetTag(string $testMethodName, string $invokedMethodName)
    {
        $fixtureDate = '2024-12-24 18:00:00';
        $fixture = new DateTime($fixtureDate);

        $tagsMock = $this->getMockBuilder(ArrayCollection::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['get'])
            ->getMock();
        $tagsMock->expects($this->once())->method('get')->with(
            $this->identicalTo('searchTagId')
        )->willReturn($fixtureDate);

        $sut = $this->getMockBuilder(Subscriber::class)
            ->onlyMethods([$invokedMethodName])
            ->getMock();
        $sut->method($invokedMethodName)->willReturn($tagsMock);

        $this->assertEquals(
            $fixture,
            $this->callMethod(
                $sut,
                $testMethodName,
                ['searchTagId']
            )
        );
    }

    public static function getTagDataProvider(): Generator
    {
        yield ['getManualTagTime', 'getManualTags'];
        yield ['getSmartTagTime', 'getSmartTags'];
        yield ['getStartedCampaignTime', 'getStartedCampaigns'];
        yield ['getFinishedCampaignTime', 'getFinishedCampaigns'];
    }
}
