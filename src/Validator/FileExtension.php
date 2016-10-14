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

use Zend\Validator\InArray as InArrayValidator;

/**
 * FileExtension validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class FileExtension extends AbstractValidator
{
    /**
     * Unsupported file extension
     *
     * @const UNSUPPORTED_EXTENSION
     */
    const UNSUPPORTED_EXTENSION = 'unsupportedExtension';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates = [
        self::UNSUPPORTED_EXTENSION => "'%value%' contains an unsupported file extension",
    ];

    /**
     * Array of supported file extensions
     *
     * @var array
     */
    protected $haystack;

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

        $value = strtoupper($value);

        $inArrayValidator = new InArrayValidator([
            'haystack' => $this->getHaystack(),
            'strict'   => true,
        ]);

        if (!$inArrayValidator->isValid($value)) {
            $this->error(self::UNSUPPORTED_EXTENSION);
            return false;
        }

        return true;
    }

    /**
     * Set array of supported file extensions
     *
     * @return array
     */
    public function getHaystack()
    {
        return $this->haystack;
    }

    /**
     * Get array of supported file extensions
     *
     * @param array $haystack Haystack
     *
     * @return FileExtension
     */
    public function setHaystack($haystack)
    {
        $this->haystack = $haystack;

        return $this;
    }

}