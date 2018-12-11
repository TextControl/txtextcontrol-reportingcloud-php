<?php
declare(strict_types=1);

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

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait FileFormatsTrait
 *
 * @package TxTextControl\ReportingCloud
 */
trait FileFormatsTrait
{
    /**
     * Return array of image formats (extensions) supported by ReportingCloud
     *
     * @return array
     */
    public static function getImageFormats(): array
    {
        return [
            'BMP',
            'GIF',
            'JPG',
            'PNG',
        ];
    }

    /**
     * Return array of template formats (extensions) supported by ReportingCloud
     *
     * @return array
     */
    public static function getTemplateFormats(): array
    {
        return [
            'DOC',
            'DOCX',
            'RTF',
            'TX',
        ];
    }

    /**
     * Return array of document formats (extensions) supported by ReportingCloud
     *
     * @return array
     */
    public static function getDocumentFormats(): array
    {
        return [
            'DOC',
            'DOCX',
            'HTML',
            'PDF',
            'RTF',
            'TX',
        ];
    }

    /**
     * Return array of return formats (extensions) supported by ReportingCloud
     *
     * @return array
     */
    public static function getReturnFormats(): array
    {
        return [
            'DOC',
            'DOCX',
            'HTML',
            'PDF',
            'PDFA',
            'RTF',
            'TX',
        ];
    }
}
