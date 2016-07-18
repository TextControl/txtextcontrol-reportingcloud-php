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
     * Statically call a Validator
     *
     * @param mixed  $value     Value
     * @param string $className Class name
     * @param array  $options   Options
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public static function execute($value, $className, array $options = [])
    {
        if (count($options) > 0 && array_values($options) === $options) {
            throw new InvalidArgumentException(
                'Invalid options provided via "options" parameter; must be an associative array'
            );
        }

        $fullyQualifiedClassName = sprintf('%s\%s', __NAMESPACE__, $className);

        if (!class_exists($fullyQualifiedClassName)) {
            throw new InvalidArgumentException(
                sprintf('%s does not exist and can therefore not be called statically', $fullyQualifiedClassName)
            );
        }

        $pluginManager = static::getPluginManager();

        $validator = $pluginManager->get($fullyQualifiedClassName, $options);

        $ret = $validator->isValid($value);

        if (false === $ret) {
            $message  = null;
            $messages = $validator->getMessages();
            if (count($messages) > 0) {
                $message = array_shift($messages);
            }
            throw new InvalidArgumentException($message);
        }

        return $ret;
    }
}
