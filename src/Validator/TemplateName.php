<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud\Validator;

use TxTextControl\ReportingCloud\Validator\TemplateFormat as TemplateFormatValidator;

/**
 * TemplateName validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TemplateName extends AbstractValidator
{
    /**
     * Invalid path
     *
     * @const INVALID_PATH
     */
    const INVALID_PATH = 'invalidPath';

    /**
     * Invalid extension
     *
     * @const INVALID_EXTENSION
     */
    const INVALID_EXTENSION = 'invalidExtension';

    /**
     * Invalid basename
     *
     * @const INVALID_BASENAME
     */
    const INVALID_BASENAME = 'invalidBasename';

    /**
     * Unsupported FileExtension
     *
     * @const UNSUPPORTED_EXTENSION
     */
    const UNSUPPORTED_EXTENSION = 'unsupportedExtension';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_PATH          => "'%value%' contains path information ('/', '.', or '..')",
        self::INVALID_EXTENSION     => "'%value%' contains an invalid file extension",
        self::INVALID_BASENAME      => "'%value%' contains an invalid file basename",
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

        if (0 === strlen($basename) || $basename == ".{$extension}") {
            $this->error(self::INVALID_BASENAME);
            return false;
        }

        if (0 === strlen($extension)) {
            $this->error(self::INVALID_EXTENSION);
            return false;
        }

        $templateFormatValidator = new TemplateFormatValidator();
        if (!$templateFormatValidator->isValid($extension)) {
            $this->error(self::UNSUPPORTED_EXTENSION);
            return false;
        }

        return true;
    }

}