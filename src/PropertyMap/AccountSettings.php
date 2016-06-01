<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/ReportingCloud.PHP for the canonical source repository
 * @license   https://github.com/TextControl/ReportingCloud.PHP/blob/master/LICENSE.md New BSD License
 * @copyright © 2016 Text Control GmbH
 */
namespace TXTextControl\ReportingCloud\PropertyMap;

/**
 * AccountSettings property map
 *
 * @package TXTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class AccountSettings extends AbstractPropertyMap
{
    /**
     * Set the property map of AccountSettings
     */
    public function __construct()
    {
        $this->setMap([
            'serialNumber'      => 'serial_number',
            'createdDocuments'  => 'created_documents',
            'uploadedTemplates' => 'uploaded_templates',
            'maxDocuments'      => 'max_documents',
            'maxTemplates'      => 'max_templates',
            'validUntil'        => 'valid_until',
        ]);
    }
}
