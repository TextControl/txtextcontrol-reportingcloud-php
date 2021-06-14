<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2021 Text Control GmbH
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
        $map = [
            'dateTimeFormat'         => 'date_time_format',
            'mergeBlocks'            => 'merge_blocks',
            'mergeFields'            => 'merge_fields',
            'name'                   => 'name',
            'numericFormat'          => 'numeric_format',
            'preserveFormatting'     => 'preserve_formatting',
            'templateName'           => 'template_name',
            'text'                   => 'text',
            'textAfter'              => 'text_after',
            'textBefore'             => 'text_before',
            'userDocumentProperties' => 'user_document_properties',
        ];

        $this->setMap($map);
    }
}
