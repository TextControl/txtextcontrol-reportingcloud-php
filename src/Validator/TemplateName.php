<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/ReportingCloud.PHP for the canonical source repository
 * @license   https://github.com/TextControl/ReportingCloud.PHP/blob/master/LICENSE.md New BSD License
 * @copyright © 2016 Text Control GmbH
 */
namespace TXTextControl\ReportingCloud\Validator;

use TXTextControl\ReportingCloud\Validator\TemplateFormats as TemplateFormatsValidator;

/**
 * TemplateName validator
 *
 * @package TXTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TemplateName extends AbstractValidator
{
    /**
     * Invalid path
     *
     * @const INVALID_PATH
     */
    const INVALID_PATH = 'templateNameInvalidPath';

    /**
     * Invalid extension
     *
     * @const INVALID_EXTENSION
     */
    const INVALID_EXTENSION = 'templateNameInvalidExtension';

    /**
     * Invalid basename
     *
     * @const INVALID_BASENAME
     */
    const INVALID_BASENAME = 'templateNameInvalidBasename';

    /**
     * Unsupported Extension
     *
     * @const UNSUPPORTED_EXTENSION
     */
    const UNSUPPORTED_EXTENSION = 'templateNameUnsupportedExtension';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_PATH          => "'%value%' contains path information ('/', '.', or '..')",
        self::INVALID_EXTENSION     => "'%value%' is contains an invalid file extension",
        self::INVALID_BASENAME      => "'%value%' is contains an invalid file basename",
        self::UNSUPPORTED_EXTENSION => "'%value%' contains an unsupported file extension",
    ];

    /**
     * Returns true, if value is valid. False otherwise.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->setValue($value);

        if (basename($value) != $value) {
            $this->error(self::INVALID_PATH);
            return false;
        }

        $basename  = pathinfo($value, PATHINFO_BASENAME);
        $basename  = trim($basename);

        $extension = pathinfo($value, PATHINFO_EXTENSION);
        $extension = trim($extension);

        if (empty($basename) || $basename == ".{$extension}") {
            $this->error(self::INVALID_BASENAME);
            return false;
        }

        if (empty($extension)) {
            $this->error(self::INVALID_EXTENSION);
            return false;
        }

        $templateFormatsValidator = new TemplateFormatsValidator();

        if (!$templateFormatsValidator->isValid($extension)) {
            $this->error(self::UNSUPPORTED_EXTENSION);
            return false;
        }

        return true;
    }

}