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

/**
 * TypeString validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TypeString extends AbstractValidator
{

    /**
     * Invalid filename
     *
     * @const INVALID_TYPE
     */
    const INVALID_TYPE = 'invalidType';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_TYPE => "'%value%' must be of type string",
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

        if (!is_string($value)) {
            $this->error(self::INVALID_TYPE);
            return false;
        }

        return true;
    }

}