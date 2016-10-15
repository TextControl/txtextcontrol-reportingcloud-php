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
    /**
     * ReportingCloud Filter classes
     *
     * @var array
     */
    static protected $invokableClasses = [
                        BooleanToString::class,
                        DateTimeToTimestamp::class,
                        TimestampToDateTime::class,
    ];

    /**
     * Get plugin manager for loading filter classes, adding ReportingCloud Filter classes
     *
     * @return \Zend\Filter\FilterPluginManager
     */
    public static function getPluginManager()
    {
        $pluginManager = parent::getPluginManager();

        foreach (self::$invokableClasses as $invokableClass) {

            $segments = explode('\\', $invokableClass);
            $name     = array_pop($segments);

            $pluginManager->setInvokableClass($name, $invokableClass);
        }

        return $pluginManager;
    }
}