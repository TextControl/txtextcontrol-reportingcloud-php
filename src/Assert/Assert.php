<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2021 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Class Assert
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class Assert extends AbstractAssert
{
    use AssertApiKeyTrait;
    use AssertBase64DataTrait;
    use AssertBaseUriTrait;
    use AssertCultureTrait;
    use AssertDateTimeTrait;
    use AssertDocumentDividerTrait;
    use AssertDocumentExtensionTrait;
    use AssertDocumentThumbnailExtensionTrait;
    use AssertFilenameExistsTrait;
    use AssertImageFormatTrait;
    use AssertLanguageTrait;
    use AssertOneOfTrait;
    use AssertPageTrait;
    use AssertRangeTrait;
    use AssertRemoveTrait;
    use AssertReturnFormatTrait;
    use AssertTemplateExtensionTrait;
    use AssertTemplateFormatTrait;
    use AssertTemplateNameTrait;
    use AssertTimestampTrait;
    use AssertZoomFactorTrait;
    use ValueToStringTrait;
}
