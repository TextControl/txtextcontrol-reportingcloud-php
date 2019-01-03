<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
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
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
    {
        $expected = [
            'serialNumber'            => 'serial_number',
            'createdDocuments'        => 'created_documents',
            'uploadedTemplates'       => 'uploaded_templates',
            'maxDocuments'            => 'max_documents',
            'maxTemplates'            => 'max_templates',
            'validUntil'              => 'valid_until',
            'proofingTransactions'    => 'proofing_transactions',
            'maxProofingTransactions' => 'max_proofing_transactions',
        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
