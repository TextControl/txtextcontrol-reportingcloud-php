<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\PropertyMap;

/**
 * DocumentSettings property map
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class DocumentSettings extends AbstractPropertyMap
{
    /**
     * Set the property map of DocumentSettings
     */
    public function __construct()
    {
        $map = [
            'author'               => 'author',
            'creationDate'         => 'creation_date',
            'creatorApplication'   => 'creator_application',
            'documentSubject'      => 'document_subject',
            'documentTitle'        => 'document_title',
            'lastModificationDate' => 'last_modification_date',
            'userPassword'         => 'user_password',
        ];

        $this->setMap($map);
    }
}
