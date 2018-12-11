<?php

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

namespace TxTextControl\ReportingCloud\Validator;

// @see: \TxTextControl\ReportingCloud\Assert\AssertLanguageTrait

/**
 * Language validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class Language extends AbstractResourceValidator
{
    /**
     * Language constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $filename = realpath(__DIR__ . '/../../data/dictionaries.php');

        $this->setFilename($filename);

        parent::__construct($options);
    }
}
