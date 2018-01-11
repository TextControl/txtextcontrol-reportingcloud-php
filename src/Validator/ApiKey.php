<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2018 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Validator;

use TxTextControl\ReportingCloud\Validator\TypeString as TypeStringValidator;
use Zend\Validator\StringLength as StringLengthValidator;

/**
 * ApiKey validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ApiKey extends AbstractValidator
{
    /**
     * Minimum API key length
     *
     * @const MIN
     */
    const MIN = 20;

    /**
     * Maximum API key length
     *
     * @const MIN
     */
    const MAX = 45;

    /**
     * Invalid type
     *
     * @const INVALID_TYPE
     */
    const INVALID_TYPE = 'invalidType';

    /**
     * Invalid zoom factor
     *
     * @const INVALID_STRING
     */
    const INVALID_STRING = 'invalidString';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates
        = [
            self::INVALID_TYPE   => "'%value%' must be an integer",
            self::INVALID_STRING => "'%value%' contains an invalid API key",
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

        $typeStringValidator = new TypeStringValidator();
        if (!$typeStringValidator->isValid($value)) {
            $this->error(self::INVALID_TYPE);

            return false;
        }

        $options = [
            'min' => self::MIN,
            'max' => self::MAX,
        ];

        $stringLengthValidator = new StringLengthValidator($options);
        if (!$stringLengthValidator->isValid($value)) {
            $this->error(self::INVALID_STRING);

            return false;
        }

        return true;
    }
}
