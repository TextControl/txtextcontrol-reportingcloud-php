<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use PHPUnit_Framework_TestCase;

class AssertTest extends PHPUnit_Framework_TestCase
{
    use AssertApiKeyTestTrait;
    use AssertBase64DataTestTrait;
    use AssertCultureTestTrait;
    use AssertDateTimeTestTrait;
    use AssertDocumentDividerTestTrait;
    use AssertDocumentExtensionTestTrait;
    use AssertFilenameExistsTestTrait;
    use AssertImageFormatTestTrait;
    use AssertLanguageTestTrait;
    use AssertPageTestTrait;
    use AssertReturnFormatTestTrait;
    use AssertTemplateExtensionTestTrait;
    use AssertTemplateFormatTestTrait;
    use AssertTemplateNameTestTrait;
    use AssertTimestampTestTrait;
    use AssertZoomFactorTestTrait;
}
