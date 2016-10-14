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

use DateTime as DateTimeClass;
use DateTimeZone;
use TxTextControl\ReportingCloud\Validator\TypeString as TypeStringValidator; // alias due to naming conflict with TxTextControl\ReportingCloud\Validator\DateTime

/**
 * DateTime validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class DateTime extends AbstractValidator
{
    /**
     * Invalid type
     *
     * @const INVALID_TYPE
     */
    const INVALID_TYPE = 'invalidType';

    /**
     * Invalid length
     *
     * @const INVALID_LENGTH
     */
    const INVALID_LENGTH = 'invalidLength';

    /**
     * Invalid syntax
     *
     * @const INVALID_SYNTAX
     */
    const INVALID_SYNTAX = 'invalidSyntax';

    /**
     * Invalid offset
     *
     * @const INVALID_OFFSET
     */
    const INVALID_OFFSET = 'invalidOffset';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_TYPE   => "'%value%' must be a string",
        self::INVALID_LENGTH => "'%value%' has an invalid number of characters in it",
        self::INVALID_SYNTAX => "'%value%' is syntactically invalid",
        self::INVALID_OFFSET => "'%value%' has an invalid offset",
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

        if ($this->getRequiredLength() !== strlen($value)) {
            $this->error(self::INVALID_LENGTH);
            return false;
        }

        $dateTimeZone = new DateTimeZone($this->getTimeZone());

        $dateTime = DateTimeClass::createFromFormat($this->getDateFormat(), $value, $dateTimeZone);

        if (false === $dateTime) {
            $this->error(self::INVALID_SYNTAX);
            return false;
        }

        if (0 !== $dateTime->getOffset()) {
            $this->error(self::INVALID_OFFSET);
            return false;
        }

        return true;
    }
    
    /**
     * Return the required length (in characters) of the date/time string
     *
     * @return int
     */
    protected function getRequiredLength()
    {
        $dateTimeZone = new DateTimeZone($this->getTimeZone());
        $dateTime     = new DateTimeClass('now', $dateTimeZone);

        return strlen($dateTime->format($this->getDateFormat()));
    }
}