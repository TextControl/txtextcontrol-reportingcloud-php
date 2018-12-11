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

namespace TxTextControl\ReportingCloud\Filter2;

/**
 * Class Filter2
 *
 * @package TxTextControl\ReportingCloud
 */
class Filter2
{
    use Filter2BooleanToStringTrait;
    use Filter2DateTimeToTimestampTrait;
    use Filter2TimestampToDateTimeTrait;
}
