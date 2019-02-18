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
    // <editor-fold desc="Abstract methods">

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    // </editor-fold>

    public function testAssertTemplateName(): void
    {
        Assert::assertTemplateName('template.tx');
        Assert::assertTemplateName('template.TX');
        Assert::assertTemplateName('TEMPLATE.TX');

        Assert::assertTemplateName('template.doc');
        Assert::assertTemplateName('template.DOC');
        Assert::assertTemplateName('TEMPLATE.DOC');

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "template.xxx" contains an unsupported file extension
     */
    public function testAssertTemplateNameInvalidUsupportedFileExtension(): void
    {
        Assert::assertTemplateName('template.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/path/to/template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidAbsolutePath(): void
    {
        Assert::assertTemplateName('/path/to/template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/../template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidDirectoryTraversal1(): void
    {
        Assert::assertTemplateName('/../template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "../template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidDirectoryTraversal2(): void
    {
        Assert::assertTemplateName('../template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "./template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidPath4(): void
    {
        Assert::assertTemplateName('./template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("invalid.xxx")
     */
    public function testAssertTemplateNameInvalidWithCustomMessage(): void
    {
        Assert::assertTemplateName('invalid.xxx', 'Custom error message ("%s")');
    }
}
