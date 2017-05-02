<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\StaticValidator;

class StaticValidatorTest extends PHPUnit_Framework_TestCase
{

    public function testExecuteValid()
    {
        $this->assertTrue(StaticValidator::execute(123, 'TypeInteger', [
            'a' => 1,
            'b' => 2,
        ]));
        $this->assertTrue(StaticValidator::execute(123, 'TypeInteger', []));
        $this->assertTrue(StaticValidator::execute(123, 'TypeInteger'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExecuteInvalidClassDoesNotExist()
    {
        StaticValidator::execute(123, 'InvalidClassName');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExecuteInvalidOptions()
    {
        StaticValidator::execute(123, 'TypeInteger', [
            1,
            2,
            3,
        ]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExecuteInvalidValidatorReturnsFalse()
    {
        StaticValidator::execute('invalid', 'TypeInteger');
    }

}
