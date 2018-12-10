<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use PHPUnit_Framework_TestCase;

class AssertTest extends PHPUnit_Framework_TestCase
{
    use AssertApiKeyTestTrait;
    use AssertBase64DataTestTrait;
    use AssertDateTimeTestTrait;
    use AssertImageFormatTestTrait;
    use AssertReturnFormatTestTrait;
    use AssertTemplateFormatTestTrait;
    use AssertTemplateExtensionTestTrait;
    use AssertZoomFactorTestTrait;
    use AssertDocumentExtensionTestTrait;
    use AssertLanguageTestTrait;
    use AssertCultureTestTrait;
    use AssertFilenameExistsTestTrait;
    use AssertPageTestTrait;
    use AssertTemplateNameTestTrait;
    use AssertTimestampTestTrait;
    use AssertDocumentDividerTestTrait;
}
