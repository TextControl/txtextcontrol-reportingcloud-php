<?php

namespace TxTextControlTest\ReportingCloud\Stdlib;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\Stdlib\ArrayUtils;

class ArrayUtilsTest extends TestCase
{
    public function testVarExportToFile()
    {
        $array = [
            'a' => 'one',
            'b' => 'two',
            'c' => 'three',
            'd' => [
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
            ],
        ];

        $filename = tempnam(sys_get_temp_dir(), hash('sha256', __CLASS__));

        $result = ArrayUtils::varExportToFile($filename, $array);

        $this->assertIsInt($result);

        $result = include $filename;

        $this->assertEquals($array, $result);

        unlink($filename);
    }
}
