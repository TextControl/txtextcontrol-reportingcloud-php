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
namespace TxTextControl\ReportingCloud\Validator;

use DirectoryIterator;
use Zend\Validator\StaticValidator as StaticValidatorValidatorZend;

/**
 * StaticValidator filter
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class StaticValidator extends StaticValidatorValidatorZend
{

    /**
     * Get plugin manager for loading filter classes, adding local Validator classes
     *
     * @return \Zend\Validator\ValidatorPluginManager
     */
    public static function getPluginManager()
    {
        $pluginManager = parent::getPluginManager();

        foreach (new DirectoryIterator(__DIR__) as $fileInfo) {

            $invokableClass = $fileInfo->getBasename('.php');

            if ($fileInfo->isDot()) {
                continue;
            }

            if (in_array($invokableClass, ['AbstractValidator', 'StaticValidator'])) {
                continue;
            }

            $pluginManager->setInvokableClass($invokableClass, __NAMESPACE__ . '\\' . $invokableClass);


        }



        

        return $pluginManager;
    }

}