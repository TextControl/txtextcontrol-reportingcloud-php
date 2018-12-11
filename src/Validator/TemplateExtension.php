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

use TxTextControl\ReportingCloud\Validator\TemplateFormat as TemplateFormatValidator;

// @see: \TxTextControl\ReportingCloud\Assert\AssertTemplateExtensionTrait

/**
 * TemplateExtension validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TemplateExtension extends FileHasExtension
{
    /**
     * TemplateExtension constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $templateFormatValidator = new TemplateFormatValidator();

        $options['haystack'] = $templateFormatValidator->getHaystack();

        parent::__construct($options);
    }
}
