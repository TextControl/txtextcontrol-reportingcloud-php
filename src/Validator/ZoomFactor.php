<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/ReportingCloud.PHP for the canonical source repository
 * @license   https://github.com/TextControl/ReportingCloud.PHP/blob/master/LICENSE.md New BSD License
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud\Validator;

use Zend\Validator\Between as BetweenValidator;

/**
 * Zoom factor validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ZoomFactor extends BetweenValidator
{
    /**
     * Minimum zoom factor
     *
     * @const MIN
     */
    const MIN = 1;

    /**
     * Maximum zoom factor
     *
     * @const MIN
     */
    const MAX = 400;

    /**
     * ZoomFactor constructor
     * 
     * @param array $options
     */
    public function __construct($options = [])
    {
        if (!is_array($options)) {
            $options = [];
        }

        $options['min']       = self::MIN;
        $options['max']       = self::MAX;
        $options['inclusive'] = true;

        return parent::__construct($options);
    }

}