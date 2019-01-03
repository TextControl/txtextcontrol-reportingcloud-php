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

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

/**
 * Trait AssertTemplateNameTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertTemplateNameTestTrait
{
    public function testAssertTemplateName()
    {
        $this->assertNull(Assert::assertTemplateName('template.tx'));
        $this->assertNull(Assert::assertTemplateName('template.TX'));
        $this->assertNull(Assert::assertTemplateName('TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateName('template.doc'));
        $this->assertNull(Assert::assertTemplateName('template.DOC'));
        $this->assertNull(Assert::assertTemplateName('TEMPLATE.DOC'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "template.xxx" contains an unsupported file extension
     */
    public function testAssertTemplateNameInvalidUsupportedFileExtension()
    {
        Assert::assertTemplateName('template.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/path/to/template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidAbsolutePath()
    {
        Assert::assertTemplateName('/path/to/template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/../template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidDirectoryTraversal1()
    {
        Assert::assertTemplateName('/../template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "../template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidDirectoryTraversal2()
    {
        Assert::assertTemplateName('../template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "./template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidPath4()
    {
        Assert::assertTemplateName('./template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("invalid.xxx")
     */
    public function testAssertTemplateNameInvalidWithCustomMessage()
    {
        Assert::assertTemplateName('invalid.xxx', 'Custom error message (%s)');
    }
}
