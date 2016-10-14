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

use Zend\Validator\File\Exists as FileExistsValidator;

/**
 * FileExists validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class FileExists extends AbstractValidator
{
    /**
     * Invalid filename
     *
     * @const INVALID_FILENAME
     */
    const INVALID_FILENAME = 'invalidFilename';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_FILENAME => "'%value%' contains an invalid filename",
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

        $fileExistsValidator = new FileExistsValidator();
        if (!$fileExistsValidator->isValid($value)) {
            $this->error(self::INVALID_FILENAME);
            return false;
        }

        return true;
    }

}