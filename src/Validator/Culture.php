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
 * Culture validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class Culture extends AbstractValidator
{
    const FILENAME = '../../resource/cultures.php';
    /**
     * Invalid syntax
     *
     * @const INVALID
     */
    const INVALID_CULTURE = 'invalidCulture';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_CULTURE => '',  // added dynamically
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

        $filename = realpath(__DIR__ . DIRECTORY_SEPARATOR . self::FILENAME);

        $values = include $filename;

        if (!in_array($value, $values)) {

            $message = sprintf("'%s' is not a valid culture value. Valid values are: '%s'"
                , $value
                , implode("', '", $values));

            $this->setMessage($message, self::INVALID_CULTURE);
            $this->error(self::INVALID_CULTURE);

            return false;
        }

        return true;
    }
}