<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\IncorrectWord as PropertyMap;

/**
 * Class IncorrectWordTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class IncorrectWordTest extends TestCase
{
    /**
     * @var PropertyMap
     * @psalm-suppress PropertyNotSetInConstructor
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
            'length'      => 'length',
            'start'       => 'start',
            'text'        => 'text',
            'isDuplicate' => 'is_duplicate',
            'language'    => 'language',
        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
