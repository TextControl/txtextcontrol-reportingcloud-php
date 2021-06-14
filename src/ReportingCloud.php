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
                // Options
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

        $this->setDefaultOptions();
    }

    // </editor-fold>
}
