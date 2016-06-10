<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud\Validator;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use Zend\Validator\StaticValidator as ZendStaticValidator;

/**
 * StaticValidator validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class StaticValidator extends ZendStaticValidator
{
    /**
     * @param mixed  $value         Value
     * @param string $classBaseName Class name
     * @param array  $options       Options
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public static function execute($value, $classBaseName, array $options = [])
    {

        if ($options && array_values($options) === $options) {
            throw new InvalidArgumentException(
                'Invalid options provided via $options argument; must be an associative array'
            );
        }

        $className = __NAMESPACE__ . "\\{$classBaseName}";

        $validator = static::getPluginManager()->get($className, $options);

        $ret = $validator->isValid($value);

        if (false === $ret) {
            throw new InvalidArgumentException($validator->getFirstMessage());
        }

        return $ret;
    }
}
