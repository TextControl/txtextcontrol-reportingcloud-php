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

use TxTextControl\ReportingCloud\ReportingCloud;
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
     * Unsupported file extension
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
            self::UNSUPPORTED_DIVIDER => "'%value%' contains an unsupported document divider",
        ];

    public function isValid($value)
    {
        $this->setValue($value);

        $options = [
            'haystack' => [
                ReportingCloud::DOCUMENT_DIVIDER_NONE,
                ReportingCloud::DOCUMENT_DIVIDER_NEW_PARAGRAPH,
                ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
            ],
            'strict'   => false,
        ];

        $inArrayValidator = new InArrayValidator($options);

        if (!$inArrayValidator->isValid($value)) {
            $this->error(self::UNSUPPORTED_DIVIDER);

            return false;
        }

        return true;
    }
}
