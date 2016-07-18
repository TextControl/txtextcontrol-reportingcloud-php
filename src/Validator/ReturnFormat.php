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
    public function __construct($options = [])
    {
        $options['haystack'] = [
            'DOC' ,
            'DOCX',
            'HTML',
            'PDF' ,
            'RTF' ,
            'TX'  ,
        ];

        parent::__construct($options);
    }

}