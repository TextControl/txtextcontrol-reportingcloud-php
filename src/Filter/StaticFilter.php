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
namespace TxTextControl\ReportingCloud\Filter;

use Zend\Filter\StaticFilter as StaticFilterFilterZend;

/**
 * StaticFilter filter
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class StaticFilter extends StaticFilterFilterZend
{

    public static function getPluginManager()
    {
        $pluginManager = parent::getPluginManager();

        $invokableClasses =  [
            ['BooleanToString'     => __NAMESPACE__ . '\BooleanToString'],
            ['DateTimeToTimestamp' => __NAMESPACE__ . '\DateTimeToTimestamp'],
            ['TimestampToDateTime' => __NAMESPACE__ . '\TimestampToDateTime'],
        ];

        foreach ($invokableClasses as $invokableClass) {
            $pluginManager->setInvokableClass(key($invokableClass), array_pop($invokableClass));
        }

        return $pluginManager;
    }

}