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
use TxTextControl\ReportingCloud\PropertyMap\TrackedChanges as PropertyMap;

/**
 * Class TrackedChangesTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TrackedChangesTest extends TestCase
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
            'changeKind'            => 'change_kind',
            'changeTime'            => 'change_time',
            'defaultHighlightColor' => 'default_highlight_color',
            'highlightColor'        => 'highlight_color',
            'highlightMode'         => 'highlight_mode',
            'id'                    => 'id',
            'length'                => 'length',
            'start'                 => 'start',
            'text'                  => 'text',
            'userName'              => 'username',
        ];

        self::assertSame($expected, $this->propertyMap->getMap());
    }
}
