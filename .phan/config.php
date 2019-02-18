<?php

return [
    'target_php_version'              => null,
    'directory_list'                  => [
        'src',
        'test',
        'vendor',
    ],
    'exclude_analysis_directory_list' => [
        'vendor',
    ],
    'suppress_issue_types'            => [
        'PhanUnreferencedUseNormal',
    ],

];
