<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\PropertyMap;

/**
 * IncorrectWord property map
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class IncorrectWord extends AbstractPropertyMap
{
    /**
     * Set the property map of IncorrectWord
     */
    public function __construct()
    {
        $map = [
            'length'      => 'length',
            'start'       => 'start',
            'text'        => 'text',
            'isDuplicate' => 'is_duplicate',
            'language'    => 'language',
        ];

        $this->setMap($map);
    }
}
