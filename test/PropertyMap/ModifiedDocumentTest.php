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
 * @copyright © 2021 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\ModifiedDocument as PropertyMap;

/**
 * Class ModifiedDocumentTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ModifiedDocumentTest extends TestCase
{
    /**
     * @var PropertyMap
     */
    protected $propertyMap;

    public function setUp(): void
    {
        $this->propertyMap = new PropertyMap();
    }

    public function tearDown(): void
    {
        // $this->propertyMap = null;
    }

    public function testValid(): void
    {
        $expected = [
            'document' => 'document',
            'removed'  => 'removed',
        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
