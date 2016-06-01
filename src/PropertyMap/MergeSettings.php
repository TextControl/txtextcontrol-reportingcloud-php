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
 * MergeSettings property map
 *
 * @package TXTextControl\ReportingCloud
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
