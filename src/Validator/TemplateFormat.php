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

// @see: \TxTextControl\ReportingCloud\Assert\AssertTemplateFormatTrait

/**
 * TemplateFormat validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TemplateFormat extends FileExtension
{
    /**
     * TemplateFormat constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $options['haystack'] = [
            'DOC',
            'DOCX',
            'RTF',
            'TX',
        ];

        parent::__construct($options);
    }
}
