<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2018 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud;

use TxTextControl\ReportingCloud\Filter\StaticFilter;
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\DocumentSettings as DocumentSettingsPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\MergeSettings as MergeSettingsPropertyMap;
use TxTextControl\ReportingCloud\Validator\StaticValidator;

/**
 * Trait BuildTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait BuildTrait
{
    /**
     * Build Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Using the passed propertyMap, recursively build array
     *
     * @param array       $array       Array
     * @param PropertyMap $propertyMap PropertyMap
     *
     * @return array
     */
    protected function buildPropertyMapArray(array $array, PropertyMap $propertyMap)
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
     * Using passed documentsData array, build array for backend
     *
     * @param array $array AppendDocument array
     *
     * @return array
     */
    protected function buildDocumentsArray(array $array)
    {
        $ret = [];

        foreach ($array as $inner) {
            StaticValidator::execute($inner, 'TypeArray');
            $document = [];
            foreach ($inner as $key => $value) {
                switch ($key) {
                    case 'filename':
                        StaticValidator::execute($value, 'FileExists');
                        StaticValidator::execute($value, 'DocumentExtension');
                        $value                = realpath($value);
                        $binary               = file_get_contents($value);
                        $document['document'] = base64_encode($binary);
                        break;
                    case 'divider':
                        StaticValidator::execute($value, 'DocumentDivider');
                        $document['documentDivider'] = $value;
                        break;
                }
            }
            $ret[] = $document;
        }

        return $ret;
    }

    /**
     * Using passed documentsSettings array, build array for backend
     *
     * @param array $array
     *
     * @return array
     */
    protected function buildDocumentSettingsArray(array $array)
    {
        $ret = [];

        $propertyMap = new DocumentSettingsPropertyMap();

        foreach ($propertyMap->getMap() as $property => $key) {
            if (isset($array[$key])) {
                $value = $array[$key];
                if ('_date' == substr($key, -5)) {
                    StaticValidator::execute($value, 'Timestamp');
                    $value = StaticFilter::execute($value, 'TimestampToDateTime');
                }
                $ret[$property] = $value;
            }
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
    protected function buildMergeSettingsArray(array $array)
    {
        $ret = [];

        $propertyMap = new MergeSettingsPropertyMap();

        foreach ($propertyMap->getMap() as $property => $key) {
            if (isset($array[$key])) {
                $value = $array[$key];
                if ('culture' == $key) {
                    StaticValidator::execute($value, 'Culture');
                }
                if ('remove_' == substr($key, 0, 7)) {
                    StaticValidator::execute($value, 'TypeBoolean');
                }
                if ('_date' == substr($key, -5)) {
                    StaticValidator::execute($value, 'Timestamp');
                    $value = StaticFilter::execute($value, 'TimestampToDateTime');
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
    protected function buildFindAndReplaceDataArray(array $array)
    {
        $ret = [];

        foreach ($array as $key => $value) {
            array_push($ret, [
                $key,
                $value,
            ]);
        }

        return $ret;
    }
}
