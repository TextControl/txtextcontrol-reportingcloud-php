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
 * MergeSettings property map
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class MergeSettings extends AbstractPropertyMap
{
    /**
     * Set the property map of MergeSettings
     */
    public function __construct()
    {
        $this->setMap([
            'author'                   => 'author',
            'creationDate'             => 'creation_date',
            'creatorApplication'       => 'creator_application',
            'documentSubject'          => 'document_subject',
            'documentTitle'            => 'document_title',
            'lastModificationDate'     => 'last_modification_date',
            'removeEmptyBlocks'        => 'remove_empty_blocks',
            'removeEmptyFields'        => 'remove_empty_fields',
            'removeEmptyImages'        => 'remove_empty_images',
            'removeTrailingWhitespace' => 'remove_trailing_whitespace',
            'userPassword'             => 'user_password',
        ]);
    }
}
