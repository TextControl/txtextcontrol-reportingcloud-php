<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2017 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Validator;

/**
 * Language validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class Language extends AbstractValidator
{
    /**
     * Unsupported file extension
     *
     * @const UNSUPPORTED_EXTENSION
     */
    const UNSUPPORTED_EXTENSION = 'unsupportedExtension';
    /**
     * Unsupported file extension
     *
     * @const UNSUPPORTED_EXTENSION
     */
    const INVALID_SYNTAX = 'invalidSyntax';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates = [
        self::UNSUPPORTED_EXTENSION => "'%value%' has an unsupported file extension. Only the '.dic' extension is supported. The 'language' parameter must be passed with its '.dic' extension. For example 'en_US.dic' or 'es_ES.dic'",
        self::INVALID_SYNTAX        => "'%value%' is an invalid syntax for the 'language' parameter.",
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

        if ('.dic' != substr($value, -4)) {
            $this->error(self::UNSUPPORTED_EXTENSION);

            return false;
        }

        $valueParts = locale_parse($value);

        if (!isset($valueParts['language'])) {
            $this->error(self::INVALID_SYNTAX);

            return false;
        }

        if (2 !== strlen($valueParts['language'])) {
            $this->error(self::INVALID_SYNTAX);

            return false;
        }

        //@todo: Add further validation here

        return true;
    }
}