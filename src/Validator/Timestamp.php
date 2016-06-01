<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md New BSD License
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud\Validator;

use Zend\Validator\Between as BetweenValidator;

/**
 * Timestamp validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class Timestamp extends AbstractValidator
{
    /**
     * Not numeric
     *
     * @const INVALID_NOT_NUMERIC
     */
    const INVALID_NOT_NUMERIC  = 'timestampNotNumeric';

    /**
     * Not in range
     *
     * @const INVALID_NOT_IN_RANGE
     */
    const INVALID_NOT_IN_RANGE = 'timestampNotInRange';

    /**
     * Message templates
     * 
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_NOT_NUMERIC  => "'%value%' is not numeric",
        self::INVALID_NOT_IN_RANGE => "'%value%' is not in the required range",
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

        if (!is_numeric($value)) {
            $this->error(self::INVALID_NOT_NUMERIC);
            return false;
        }

        $betweenValidator = new BetweenValidator([
             'min'       => 0,
             'max'       => PHP_INT_MAX,
             'inclusive' => true]);

        if (!$betweenValidator->isValid($value)) {
            $this->error(self::INVALID_NOT_IN_RANGE);
            return false;
        }

        return true;
    }

}
