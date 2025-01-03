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

use D3\KlicktippPhpClient\Entities\Account;
use D3\KlicktippPhpClient\Resources\Account as AccountEndpoint;
use D3\KlicktippPhpClient\tests\TestCase;
use Doctrine\Common\Collections\ArrayCollection;
use Generator;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use ReflectionException;

/**
 * @coversNothing
 */
class AccountTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->entity = new Account(
            [
                AccountEndpoint::UID => "1094633",
                AccountEndpoint::STATUS             => "1",
                AccountEndpoint::TIER               => 10000,
                AccountEndpoint::USERGROUP => "16",
                AccountEndpoint::USERNAME => "myUsername",
                AccountEndpoint::EMAIL => "myemail@mydomain.com",
                AccountEndpoint::FIRSTNAME => "John",
                AccountEndpoint::LASTNAME => "Doe",
                AccountEndpoint::COMPANY => "ShopCompany",
                AccountEndpoint::WEBSITE => "https://mywebsite.com",
                AccountEndpoint::STREET => "Unter den Linden 20",
                AccountEndpoint::CITY => "Berlin",
                AccountEndpoint::STATE => "",
                AccountEndpoint::ZIP => "01100",
                AccountEndpoint::COUNTRY => "DE",
                AccountEndpoint::PHONE => "",
                AccountEndpoint::FAX => "",
                AccountEndpoint::AFFILIATE_ID => "197030",
                AccountEndpoint::ACCESS_RIGHTS => [
                    "administer klicktipp" => false,
                    "access facebook audience" => false,
                    "access translation translater"  => false,
                    "access translation admin" => false,
                    "use whitelabel domain" => false,
                    "access email editor" => true,
                    "access user segments" => false,
                    "access feature limiter" => true,
                ],
                AccountEndpoint::SENDERS => [
                    "email" => [
                        "myemail@mydomain.com" => "myemail@mydomain.com (ohne DKIM Signatur � eingeschr�nkte Zustellbarkeit)",
                    ],
                    "reply_email" => [
                        "myemail@mydomain.com" => "myemail@mydomain.com",
                    ],
                    "sms" => [],
                    "defaultEmail" => "myemail@mydomain.com",
                    "defaultReplyEmail" => "myemail@mydomain.com",
                    "domains" => [],
                    "providers" => [],
                    "previewEmails" => [],
                ],
                AccountEndpoint::GMAIL_PREVIEW => "gmail-inspector@klick-tipp.team",
                AccountEndpoint::LIMITS => [
                    "automation" => "10",
                    "statistics" => "5",
                ],
                AccountEndpoint::PREFERENCES => [
                    "colors" => [
                        "start" => "yellow-dark",
                        "decision" => "violet-dark",
                        "goal" => "",
                        "goto" => "violet-dark",
                        "wait" => "",
                        "start automation" => "yellow-dark",
                        "stop automation" => "pink-dark",
                        "exit" => "pink-dark",
                        "restart" => "pink-dark",
                        "email" => "blue-dark",
                        "sms" => "blue-dark",
                        "notify by email" => "blue-dark",
                        "notify by sms" => "blue-dark",
                        "outbound" => "blue-dark",
                        "facebook audience add" => "blue-dark",
                        "tagging" => "green-dark",
                        "untagging" => "pink-dark",
                        "unsubscribe" => "pink-dark",
                        "setfield" => "green-dark",
                        "detect name" => "green-dark",
                        "detect gender" => "green-dark",
                        "fullcontact" => "green-dark",
                    ],
                ],
                AccountEndpoint::SETTINGS => [
                    "PlainTextContentByUser" => 0,
                ],
                AccountEndpoint::SHOW_OTHER_ACCOUNT_INFO => false,
                AccountEndpoint::SHOW_SUPPORT_INFO => false,
                AccountEndpoint::SUPPORT => [
                    "username" => "klicktipp_account_username",
                    "switchAccountsLink" => [
                        "href" => "https://app.klicktipp.com/user/me/subaccount/switch",
                        "title" => "Unterkonto wechseln",
                    ],
                ],
                AccountEndpoint::LANGUAGE => "de",
                AccountEndpoint::SEGMENTS => [],
                AccountEndpoint::CUSTOMER_DATA => [
                    "isActive" => true,
                    "email"  => "myemail@mydomain.com",
                    "firstName" => "John",
                    "lastName" => "Doe",
                    "zipcode" => "01100",
                    "city" => "Berlin",
                    "street" => "Unter den Linden 20",
                    "country" => "DE",
                    "company" => "ShopCompany",
                    "product" => "KlickTipp Deluxe 10.000",
                    "order_id" => "",
                    "weight" => "1010",
                    "tier" => "10000",
                    "period" => 67,
                    "digistore_affiliate_name" => "",
                    "tracking_pixels" => "",
                    "apikeys" => false,
                    "subscriber_key" => "3xtlh8zavzz04zdc45",
                    "addOns" => [],
                ],
                AccountEndpoint::SUBSCRIPTION_INFO => [
                    "category" => "Account Platinum",
                    "tier" => "10000",
                    "term" => "monatlich",
                    "period" => 67,
                    "productID" => "107",
                    "title" => "KlickTipp Deluxe 10.000",
                    "weight" => "1010",
                    "orderID" => "",
                    "machineCategory" => "klick-tipp-account-platinum",
                    "emailAddress" => "myemail@mydomain.com",
                    "groupId" => "16",
                    "aMemberId" => "179045",
                ],
                AccountEndpoint::ACTIVE_PAYMENTS => [],
            ]
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Account::__construct
     */
    public function testConstruct(): void
    {
        $elements = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $endpoint = $this->getMockBuilder(AccountEndpoint::class)
            ->disableOriginalConstructor()
            ->getMock();

        $sut = new Account($elements, $endpoint);

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
     * @covers \D3\KlicktippPhpClient\Entities\Account::getId
     * @covers \D3\KlicktippPhpClient\Entities\Account::getStatus
     * @covers \D3\KlicktippPhpClient\Entities\Account::getTier
     * @covers \D3\KlicktippPhpClient\Entities\Account::getUsergroup
     * @covers \D3\KlicktippPhpClient\Entities\Account::getEmail
     * @covers \D3\KlicktippPhpClient\Entities\Account::getFirstname
     * @covers \D3\KlicktippPhpClient\Entities\Account::getLastname
     * @covers \D3\KlicktippPhpClient\Entities\Account::getCompany
     * @covers \D3\KlicktippPhpClient\Entities\Account::getWebsite
     * @covers \D3\KlicktippPhpClient\Entities\Account::getStreet
     * @covers \D3\KlicktippPhpClient\Entities\Account::getCity
     * @covers \D3\KlicktippPhpClient\Entities\Account::getState
     * @covers \D3\KlicktippPhpClient\Entities\Account::getZIP
     * @covers \D3\KlicktippPhpClient\Entities\Account::getCountry
     * @covers \D3\KlicktippPhpClient\Entities\Account::getPhone
     * @covers \D3\KlicktippPhpClient\Entities\Account::getFax
     * @covers \D3\KlicktippPhpClient\Entities\Account::getAffiliateId
     * @covers \D3\KlicktippPhpClient\Entities\Account::getAccessRights
     * @covers \D3\KlicktippPhpClient\Entities\Account::getSenders
     * @covers \D3\KlicktippPhpClient\Entities\Account::getGmailPreview
     * @covers \D3\KlicktippPhpClient\Entities\Account::getLimits
     * @covers \D3\KlicktippPhpClient\Entities\Account::getPreferences
     * @covers \D3\KlicktippPhpClient\Entities\Account::getSettings
     * @covers \D3\KlicktippPhpClient\Entities\Account::canShowOtherAccountInfo
     * @covers \D3\KlicktippPhpClient\Entities\Account::canShowSupportInfo
     * @covers \D3\KlicktippPhpClient\Entities\Account::getSupport
     * @covers \D3\KlicktippPhpClient\Entities\Account::getLanguage
     * @covers \D3\KlicktippPhpClient\Entities\Account::getSegments
     * @covers \D3\KlicktippPhpClient\Entities\Account::getCustomerData
     * @covers \D3\KlicktippPhpClient\Entities\Account::getSubscriptionInfo
     * @covers \D3\KlicktippPhpClient\Entities\Account::getActivePayments
     * @dataProvider getDataProvider
     */
    public function testGet(string $testMethod, $exepcted): void
    {
        $this->assertEquals(
            $exepcted,
            $this->callMethod(
                $this->entity,
                $testMethod,
            )
        );
    }

    public static function getDataProvider(): Generator
    {
        yield ['getId', '1094633'];
        yield ['getStatus', "1"];
        yield ['getTier', 10000];
        yield ['getUsergroup', "16"];
        yield ['getEmail', "myemail@mydomain.com"];
        yield ['getFirstname', "John"];
        yield ['getLastname', "Doe"];
        yield ['getCompany', "ShopCompany"];
        yield ['getWebsite', "https://mywebsite.com"];
        yield ['getStreet', "Unter den Linden 20"];
        yield ['getCity', "Berlin"];
        yield ['getState', ""];
        yield ['getZIP', "01100"];
        yield ['getCountry', "DE"];
        yield ['getPhone', ""];
        yield ['getFax', ""];
        yield ['getAffiliateId', "197030"];
        yield ['getAccessRights', new ArrayCollection([
            "administer klicktipp" => false,
            "access facebook audience" => false,
            "access translation translater"  => false,
            "access translation admin" => false,
            "use whitelabel domain" => false,
            "access email editor" => true,
            "access user segments" => false,
            "access feature limiter" => true,
        ])];
        yield ['getSenders', new ArrayCollection([
            "email" => [
                "myemail@mydomain.com" => "myemail@mydomain.com (ohne DKIM Signatur � eingeschr�nkte Zustellbarkeit)",
            ],
            "reply_email" => [
                "myemail@mydomain.com" => "myemail@mydomain.com",
            ],
            "sms" => [],
            "defaultEmail" => "myemail@mydomain.com",
            "defaultReplyEmail" => "myemail@mydomain.com",
            "domains" => [],
            "providers" => [],
            "previewEmails" => [],
        ])];
        yield ['getGmailPreview', "gmail-inspector@klick-tipp.team"];
        yield ['getLimits', new ArrayCollection([
            "automation" => "10",
            "statistics" => "5",
        ])];
        yield ['getPreferences', new ArrayCollection([
            "colors" => [
                "start" => "yellow-dark",
                "decision" => "violet-dark",
                "goal" => "",
                "goto" => "violet-dark",
                "wait" => "",
                "start automation" => "yellow-dark",
                "stop automation" => "pink-dark",
                "exit" => "pink-dark",
                "restart" => "pink-dark",
                "email" => "blue-dark",
                "sms" => "blue-dark",
                "notify by email" => "blue-dark",
                "notify by sms" => "blue-dark",
                "outbound" => "blue-dark",
                "facebook audience add" => "blue-dark",
                "tagging" => "green-dark",
                "untagging" => "pink-dark",
                "unsubscribe" => "pink-dark",
                "setfield" => "green-dark",
                "detect name" => "green-dark",
                "detect gender" => "green-dark",
                "fullcontact" => "green-dark",
            ],
        ])];
        yield ['getSettings', new ArrayCollection([
            "PlainTextContentByUser" => 0,
        ])];
        yield ['canShowOtherAccountInfo', false];
        yield ['canShowSupportInfo', false];
        yield ['getSupport', new ArrayCollection([
            "username" => "klicktipp_account_username",
            "switchAccountsLink" => [
                "href" => "https://app.klicktipp.com/user/me/subaccount/switch",
                "title" => "Unterkonto wechseln",
            ],
        ])];
        yield ['getLanguage', "de"];
        yield ['getSegments', new ArrayCollection([])];
        yield ['getCustomerData', new ArrayCollection([
            "isActive" => true,
            "email"  => "myemail@mydomain.com",
            "firstName" => "John",
            "lastName" => "Doe",
            "zipcode" => "01100",
            "city" => "Berlin",
            "street" => "Unter den Linden 20",
            "country" => "DE",
            "company" => "ShopCompany",
            "product" => "KlickTipp Deluxe 10.000",
            "order_id" => "",
            "weight" => "1010",
            "tier" => "10000",
            "period" => 67,
            "digistore_affiliate_name" => "",
            "tracking_pixels" => "",
            "apikeys" => false,
            "subscriber_key" => "3xtlh8zavzz04zdc45",
            "addOns" => [],
        ])];
        yield ['getSubscriptionInfo', new ArrayCollection([
            "category" => "Account Platinum",
            "tier" => "10000",
            "term" => "monatlich",
            "period" => 67,
            "productID" => "107",
            "title" => "KlickTipp Deluxe 10.000",
            "weight" => "1010",
            "orderID" => "",
            "machineCategory" => "klick-tipp-account-platinum",
            "emailAddress" => "myemail@mydomain.com",
            "groupId" => "16",
            "aMemberId" => "179045",
        ])];
        yield ['getActivePayments', new ArrayCollection()];
    }

    /**
     * @test
     * @throws ReflectionException
     * @covers \D3\KlicktippPhpClient\Entities\Account::persist
     * @dataProvider persistDataProvider
     */
    public function testPersist(
        bool $endpointSet,
        InvokedCount $endpointInvocation,
        ?bool $expectedReturn
    ): void {
        $endpointMock = $this->getMockBuilder(AccountEndpoint::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['update'])
            ->getMock();
        $endpointMock->expects($endpointInvocation)->method('update')->willReturn(true);

        $sut = new Account([AccountEndpoint::UID => 'foo'], $endpointSet ? $endpointMock : null);

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
}
