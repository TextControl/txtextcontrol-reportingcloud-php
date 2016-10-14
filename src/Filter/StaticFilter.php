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

use DirectoryIterator;
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
     * Get plugin manager for loading filter classes, adding local Filter classes
     *
     * @return \Zend\Filter\FilterPluginManager
     */
    public static function getPluginManager()
    {
        $pluginManager = parent::getPluginManager();

        foreach (new DirectoryIterator(__DIR__) as $fileInfo) {

            $invokableClass = $fileInfo->getBasename('.php');

            if ($fileInfo->isDot()) {
                continue;
            }

            if (in_array($invokableClass, ['AbstractFilter', 'StaticFilter'])) {
                continue;
            }

            $pluginManager->setInvokableClass($invokableClass, __NAMESPACE__ . '\\' . $invokableClass);
        }

        return $pluginManager;
    }

}