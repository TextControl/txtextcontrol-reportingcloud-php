<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://github.com/TextControl/txtextcontrol-reportingcloud-php/blob/master/LICENSE.md
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\PropertyMap;

/**
 * TrackedChanges property map
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TrackedChanges extends AbstractPropertyMap
{
    /**
     * Set the property map of TrackedChanges
     */
    public function __construct()
    {
        //@todo Updated case of properties
        $map = [
            'changeKind'            => 'change_kind',
            'changeTime'            => 'change_time',
            'defaultHighlightColor' => 'default_highlight_color',
            'highlightColor'        => 'highlight_color',
            'highlightMode'         => 'highlight_mode',
            'length'                => 'length',
            'start'                 => 'start',
            'id'                    => 'id',
            'text'                  => 'text',
            'userName'              => 'username',
        ];

        $this->setMap($map);
    }
}
