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
namespace TxTextControl\ReportingCloud\PropertyMap;

/**
 * TemplateInfo property map
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TemplateInfo extends AbstractPropertyMap
{
    /**
     * Set the property map of TemplateInfo
     */
    public function __construct()
    {
        $this->setMap([
            'dateTimeFormat'     => 'date_time_format',
            'mergeBlocks'        => 'merge_blocks',
            'mergeFields'        => 'merge_fields',
            'name'               => 'name',
            'numericFormat'      => 'numeric_format',
            'preserveFormatting' => 'preserve_formatting',
            'templateName'       => 'template_name',
            'text'               => 'text',
            'textAfter'          => 'text_after',
            'textBefore'         => 'text_before',
        ]);
    }
}