<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud\Validator;

use TxTextControl\ReportingCloud\Validator\AbstractValidator;
use Zend\Validator\InArray as InArrayValidator;

/**
 * ImageFormats validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ImageFormats extends AbstractValidator
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
        self::UNSUPPORTED_EXTENSION  => "'%value%' contains an unsupported file extension for an image file",
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

        $inArrayValidator = new InArrayValidator([
            'haystack' => [
                'BMP',
                'GIF',
                'JPG',
                'PNG'
            ],
            'strict' => true,
        ]);

        if (!$inArrayValidator->isValid(strtoupper($value))) {
            $this->error(self::UNSUPPORTED_EXTENSION);
            return false;
        }

        return true;
    }

}