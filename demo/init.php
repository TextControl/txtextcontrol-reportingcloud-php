<?php
declare(strict_types=1);

$pathOutput = constant('TxTextControl\ReportingCloud\PATH_OUTPUT');

if (!is_dir($pathOutput)) {
    mkdir($pathOutput);
}
