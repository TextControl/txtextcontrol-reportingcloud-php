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
namespace TxTextControl\ReportingCloud;

use TxTextControl\ReportingCloud\Filter\TimestampToDateTime as TimestampToDateTimeFilter;
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\MergeSettings as MergeSettingsPropertyMap;
use TxTextControl\ReportingCloud\Validator\StaticValidator;

/**
 * ReportingCloudTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait ReportingCloudTrait
{

    /**
     * Using the passed propertyMap, recursively build array
     *
     * @param array       $array       Array
     * @param PropertyMap $propertyMap PropertyMap
     *
     * @return array
     */
    protected function buildPropertyMapArray($array, PropertyMap $propertyMap)
    {
        $ret = [];

        foreach ($array as $key => $value) {
            $map = $propertyMap->getMap();
            if (isset($map[$key])) {
                $key = $map[$key];
            }
            if (is_array($value)) {
                $value = $this->buildPropertyMapArray($value, $propertyMap);
            }
            $ret[$key] = $value;
        }

        return $ret;
    }

    /**
     * Using passed mergeSettings array, build array for backend
     *
     * @param array $array MergeSettings array
     *
     * @return array
     */
    protected function buildMergeSettingsArray($array)
    {
        $ret = [];

        $filter      = new TimestampToDateTimeFilter();
        $propertyMap = new MergeSettingsPropertyMap();

        foreach ($propertyMap->getMap() as $property => $key) {
            if (isset($array[$key])) {
                $value = $array[$key];
                if ('remove_' == substr($key, 0, 7)) {
                    StaticValidator::execute($value, 'TypeBoolean');
                }
                if ('_date' == substr($key, -5)) {
                    StaticValidator::execute($value, 'Timestamp');
                    $value = $filter->filter($value);
                }
                $ret[$property] = $value;
            }
        }

        return $ret;
    }

    /**
     * Using passed findAndReplaceData associative array (key-value), build array for backend (list of string arrays)
     *
     * @param array $array FindAndReplaceData array
     *
     * @return array
     */
    protected function buildFindAndReplaceDataArray($array)
    {
        $ret = [];

        foreach ($array as $search => $replace) {
            array_push($ret, [$search, $replace]);
        }

        return $ret;
    }
}