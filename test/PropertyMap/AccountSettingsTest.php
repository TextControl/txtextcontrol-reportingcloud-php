<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2022 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\AccountSettings as PropertyMap;

/**
 * Class AccountSettingsTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class AccountSettingsTest extends TestCase
{
    protected PropertyMap $propertyMap;

    public function setUp(): void
    {
        $this->propertyMap = new PropertyMap();
    }

    public function tearDown(): void
    {
        unset($this->propertyMap);
    }

    public function testValid(): void
    {
        $expected = [
            'createdDocuments'        => 'created_documents',
            'maxDocuments'            => 'max_documents',
            'maxProofingTransactions' => 'max_proofing_transactions',
            'maxTemplates'            => 'max_templates',
            'proofingTransactions'    => 'proofing_transactions',
            'serialNumber'            => 'serial_number',
            'uploadedTemplates'       => 'uploaded_templates',
            'validUntil'              => 'valid_until',
        ];

        self::assertSame($expected, $this->propertyMap->getMap());
    }
}
