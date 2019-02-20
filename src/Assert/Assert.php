<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

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
    use AssertCultureTrait;
    use AssertDateTimeTrait;
    use AssertDocumentDividerTrait;
    use AssertDocumentExtensionTrait;
    use AssertImageFormatTrait;
    use AssertLanguageTrait;
    use AssertPageTrait;
    use AssertReturnFormatTrait;
    use AssertTemplateExtensionTrait;
    use AssertTemplateFormatTrait;
    use AssertTemplateNameTrait;
    use AssertTimestampTrait;
    use AssertZoomFactorTrait;
    use FilenameExistsTrait;

    /**
     * Customized version of parent::reportInvalidArgument to throw
     *
     *     TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     *
     * exception instead of parent's
     *
     *     InvalidArgumentException
     *
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidArgumentException($message);
    }
}
