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
 * AccountSettings property map
 *
 * @package TxTextControl\ReportingCloud
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
