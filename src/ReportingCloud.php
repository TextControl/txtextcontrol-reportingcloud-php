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

namespace TxTextControl\ReportingCloud;

/**
 * Class ReportingCloud
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReportingCloud extends AbstractReportingCloud
{
    use BuildTrait;
    use DeleteTrait;
    use GetTrait;
    use PostTrait;
    use PutTrait;

    // <editor-fold desc="Methods">

    /**
     * ReportingCloud constructor
     *
     * @param array|null $options
     */
    public function __construct(?array $options = null)
    {
        if (is_array($options)) {

            $methods = [
                // Credentials
                'api_key'  => 'setApiKey',
                // Credentials (deprecated, use 'api_key' only)
                'username' => 'setUsername',
                'password' => 'setPassword',
                // Settings
                'base_uri' => 'setBaseUri',
                'debug'    => 'setDebug',
                'test'     => 'setTest',
                'timeout'  => 'setTimeout',
                'version'  => 'setVersion',
            ];

            foreach ($methods as $key => $method) {
                if (array_key_exists($key, $options)) {
                    $this->$method($options[$key]);
                }
            }
        }

        $this->setDefaultSettings();
    }

    /**
     * Assign default values to settings properties
     *
     * @return ReportingCloud
     */
    private function setDefaultSettings(): self
    {
        if (null === $this->getBaseUri()) {
            $baseUri = $this->getBaseUriFromEnv() ?? self::DEFAULT_BASE_URI;
            $this->setBaseUri($baseUri);
        }

        if (null === $this->getDebug()) {
            $this->setDebug(self::DEFAULT_DEBUG);
        }

        if (null === $this->getTest()) {
            $this->setTest(self::DEFAULT_TEST);
        }

        if (null === $this->getTimeout()) {
            $this->setTimeout(self::DEFAULT_TIMEOUT);
        }

        if (null === $this->getVersion()) {
            $this->setVersion(self::DEFAULT_VERSION);
        }

        return $this;
    }

    // </editor-fold>
}
