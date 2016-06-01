<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/ReportingCloud.PHP for the canonical source repository
 * @license   https://github.com/TextControl/ReportingCloud.PHP/LICENSE.md New BSD License
 * @copyright © 2016 Text Control GmbH
 */
namespace TXTextControl\ReportingCloud\Validator;

use Zend\Validator\InArray as InArrayValidator;

/**
 * ImageFormats validator
 *
 * @package TXTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ImageFormats extends InArrayValidator
{
    /**
     * ImageFormats constructor
     * 
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->setHaystack([
            'BMP',
            'GIF',
            'JPG',
            'PNG'
        ]);

        return parent::__construct($options);
    }

    /**
     * Returns true, if value is valid. False otherwise.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $value = strtoupper($value);

        return parent::isValid($value);
    }

}