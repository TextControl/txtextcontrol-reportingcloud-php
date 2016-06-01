<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/ReportingCloud.PHP for the canonical source repository
 * @license   https://github.com/TextControl/ReportingCloud.PHP/LICENSE.md New BSD License
 * @copyright © 2016 Text Control GmbH
 */
namespace TXTextControl\ReportingCloud\Validator;

use Zend\Validator\GreaterThan as GreaterThanValidator;

/**
 * Page validator
 *
 * @package TXTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class Page extends GreaterThanValidator
{
    /**
     * Minimum page number
     *
     * @const MIN
     */
    const MIN = 1;

    /**
     * Page constructor
     * 
     * @param array $options
     */
    public function __construct($options = [])
    {
        if (!is_array($options)) {
            $options = [];
        }

        $options['min']       = self::MIN;
        $options['max']       = PHP_INT_MAX;
        $options['inclusive'] = true;

        return parent::__construct($options);
    }

}