<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

use Webmozart\Assert\Assert as ParentAssert;

class Assert extends ParentAssert
{
    use AssertApiKeyTrait;
    use AssertBase64DataTrait;
    use AssertCultureTrait;
    use AssertDateTimeTrait;
    use AssertDocumentDividerTrait;
    use AssertDocumentExtensionTrait;
    use AssertFilenameExistsTrait;
    use AssertImageFormatTrait;
    use AssertLanguageTrait;
    use AssertPageTrait;
    use AssertReturnFormatTrait;
    use AssertTemplateExtensionTrait;
    use AssertTemplateFormatTrait;
    use AssertTemplateNameTrait;
    use AssertTimestampTrait;
    use AssertZoomFactorTrait;

    /**
     * Array of image formats (extensions) supported by ReportingCloud
     *
     * @var array
     */
    protected static $imageFormats
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
    protected static $templateFormats
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
    protected static $documentFormats
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
    protected static $returnFormats
        = [
            'DOC',
            'DOCX',
            'HTML',
            'PDF',
            'PDFA',
            'RTF',
            'TX',
        ];
}
