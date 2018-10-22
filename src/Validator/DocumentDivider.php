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

use ReflectionClass;
use ReflectionException;
use TxTextControl\ReportingCloud\ReportingCloud;
use Zend\Validator\Digits as DigitsValidator;
use Zend\Validator\InArray as InArrayValidator;

/**
 * DocumentDivider validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class DocumentDivider extends AbstractValidator
{
    /**
     * Array of supported document dividers
     *
     * @var array
     */
    protected $haystack;

    /**
     * Invalid type
     *
     * @const INVALID_TYPE
     */
    const INVALID_TYPE = 'invalidType';

    /**
     * Unsupported document divider
     *
     * @const UNSUPPORTED_DIVIDER
     */
    const UNSUPPORTED_DIVIDER = 'unsupportedDocumentDivider';

    /**
     * Message templates
     *
     * @var array
     */
    protected $messageTemplates
        = [
            self::INVALID_TYPE        => "'%value%' must be numeric",
            self::UNSUPPORTED_DIVIDER => "'%value%' contains an unsupported document divider",
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

        $digitsValidator = new DigitsValidator();
        if (!$digitsValidator->isValid($value)) {
            $this->error(self::INVALID_TYPE);

            return false;
        }

        $options = [
            'haystack' => $this->getHaystack(),
            'strict'   => InArrayValidator::COMPARE_NOT_STRICT,
        ];

        $inArrayValidator = new InArrayValidator($options);
        if (!$inArrayValidator->isValid($value)) {
            $this->error(self::UNSUPPORTED_DIVIDER);

            return false;
        }

        return true;
    }

    /**
     * Set array of supported document dividers
     *
     * @return array
     */
    public function getHaystack()
    {
        if (null === $this->haystack) {
            $haystack = [];
            try {
                $reflectionClass = new ReflectionClass(new ReportingCloud());
                foreach ($reflectionClass->getConstants() as $key => $value) {
                    if (0 === strpos($key, 'DOCUMENT_DIVIDER_')) {
                        $haystack[] = $value;
                    }
                }
                $this->setHaystack($haystack);
            } catch (ReflectionException $e) {
            }
        }

        return $this->haystack;
    }

    /**
     * Get array of supported document dividers
     *
     * @param array $haystack Haystack
     *
     * @return DocumentDivider
     */
    public function setHaystack($haystack)
    {
        $this->haystack = $haystack;

        return $this;
    }
}
