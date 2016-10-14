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

use TxTextControl\ReportingCloud\Validator\TypeInteger as TypeIntegerValidator;
use Zend\Validator\GreaterThan as GreaterThanValidator;

/**
 * Page validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class Page extends AbstractValidator
{
    /**
     * Minimum page number
     *
     * @const MIN
     */
    const MIN = 1;

    /**
     * Invalid type
     *
     * @const INVALID_TYPE
     */
    const INVALID_TYPE = 'invalidType';
    
    /**
     * Invalid page
     *
     * @const INVALID_INTEGER
     */
    const INVALID_INTEGER = 'invalidInteger';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_TYPE    => "'%value%' must be an integer",
        self::INVALID_INTEGER => "'%value%' contains an invalid page number",
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

        $typeIntegerValidator = new TypeIntegerValidator();

        if (!$typeIntegerValidator->isValid($value)) {
            $this->error(self::INVALID_TYPE);
            return false;
        }

        $greaterThanValidator = new GreaterThanValidator([
            'min'       => self::MIN,
            'inclusive' => true,
        ]);

        if (!$greaterThanValidator->isValid($value)) {
            $this->error(self::INVALID_INTEGER);
            return false;
        }

        return true;
    }

}