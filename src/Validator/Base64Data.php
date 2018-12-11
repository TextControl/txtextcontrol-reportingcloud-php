<?php

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

namespace TxTextControl\ReportingCloud\Validator;

// @see: \TxTextControl\ReportingCloud\Assert\AssertBase64DataTrait

/**
 * Base64Data validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class Base64Data extends AbstractValidator
{
    /**
     * Invalid type
     *
     * @const INVALID_ENCODING
     */
    const INVALID_ENCODING = 'invalidEncoding';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates
        = [
            self::INVALID_ENCODING => "'%value%' must be base64 encoded",
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

        // If the strict parameter is set to true, base64_decode() returns false,
        // if the input contains characters from outside the base64 alphabet.

        if (false === base64_decode($this->getValue(), true)) {
            $this->error(self::INVALID_ENCODING);

            return false;
        }

        return true;
    }
}
