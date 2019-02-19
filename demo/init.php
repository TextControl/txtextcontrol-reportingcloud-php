<?php
declare(strict_types=1);

$outputPath = constant('REPORTING_CLOUD_DEMO_OUTPUT_PATH');

if (!is_dir($outputPath)) {
    mkdir($outputPath);
}
