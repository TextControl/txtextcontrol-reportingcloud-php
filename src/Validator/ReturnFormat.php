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

/**
 * ReturnFormat validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReturnFormat extends FileExtension
{
    /**
     * ReturnFormat constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $options['haystack'] = [
            'DOC',
            'DOCX',
            'HTML',
            'PDF',
            'PDFA',
            'RTF',
            'TX',
        ];

        parent::__construct($options);
    }
}
