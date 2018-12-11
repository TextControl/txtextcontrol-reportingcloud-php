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

use Zend\Validator\AbstractValidator as ZendAbstractValidator;
use Zend\Validator\ValidatorInterface as ZendValidatorInterface;

/**
 * Abstract Resource validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
abstract class AbstractResourceValidator extends ZendAbstractValidator implements ZendValidatorInterface
{
    /**
     * Invalid syntax
     *
     * @const INVALID
     */
    const INVALID_VALUE = 'invalidValue';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates
        = [
            // added dynamically
            self::INVALID_VALUE => '',
        ];

    /**
     * Filename of the resource file.
     *
     * @var string
     */
    protected $filename;

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

        $values = include $this->getFilename();

        if (!in_array($value, $values)) {

            $message = sprintf(
                "'%s' is not a valid value. Valid values are: '%s'",
                $value,
                implode("', '", $values)
            );

            $this->setMessage($message, self::INVALID_VALUE);
            $this->error(self::INVALID_VALUE);

            return false;
        }

        return true;
    }

    /**
     * Set the filename of the resource file.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Get the filename of the resource file.
     *
     * @param mixed $filename
     *
     * @return AbstractResourceValidator
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }
}
