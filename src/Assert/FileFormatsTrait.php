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
     * Array of image formats (extensions) supported by ReportingCloud
     *
     * @var array
     */
    private static $imageFormats
        = [
            'BMP',
            'GIF',
            'JPG',
            'PNG',
        ];

    /**
     * Array of template formats (extensions) supported by ReportingCloud
     *
     * @var array
     */
    private static $templateFormats
        = [
            'DOC',
            'DOCX',
            'RTF',
            'TX',
        ];

    /**
     * Array of document formats (extensions) supported by ReportingCloud
     *
     * @var array
     */
    private static $documentFormats
        = [
            'DOC',
            'DOCX',
            'HTML',
            'PDF',
            'RTF',
            'TX',
        ];

    /**
     * Array of return formats (extensions) supported by ReportingCloud
     *
     * @var array
     */
    private static $returnFormats
        = [
            'DOC',
            'DOCX',
            'HTML',
            'PDF',
            'PDFA',
            'RTF',
            'TX',
        ];

    /**
     * Return array of image formats (extensions) supported by ReportingCloud
     *
     * @return array
     */
    public static function getImageFormats(): array
    {
        return self::$imageFormats;
    }

    /**
     * Return array of template formats (extensions) supported by ReportingCloud
     *
     * @return array
     */
    public static function getTemplateFormats(): array
    {
        return self::$templateFormats;
    }

    /**
     * Return array of document formats (extensions) supported by ReportingCloud
     *
     * @return array
     */
    public static function getDocumentFormats(): array
    {
        return self::$documentFormats;
    }

    /**
     * Return array of return formats (extensions) supported by ReportingCloud
     *
     * @return array
     */
    public static function getReturnFormats(): array
    {
        return self::$returnFormats;
    }
}
