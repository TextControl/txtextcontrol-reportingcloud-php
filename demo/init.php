<?php
declare(strict_types=1);

use TxTextControl\ReportingCloud\Stdlib\Path;

if (!is_dir(Path::output())) {
    mkdir(Path::output());
}
