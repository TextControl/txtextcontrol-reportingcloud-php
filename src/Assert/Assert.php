<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

use Webmozart\Assert\Assert as ParentAssert;

class Assert extends ParentAssert
{
    use AssertApiKeyTrait;
    use AssertBase64DataTrait;
    use AssertDateTimeTrait;
    use AssertDocumentExtensionTrait;
    use AssertImageFormatTrait;
    use AssertReturnFormatTrait;
    use AssertTemplateFormatTrait;
    use AssertTemplateExtensionTrait;
    use AssertZoomFactorTrait;
    use AssertLanguageTrait;
    use AssertCultureTrait;
    use AssertFilenameExistsTrait;
    use AssertPageTrait;
    use AssertTemplateNameTrait;
    use AssertTimestampTrait;
    use AssertDocumentDividerTrait;
}
