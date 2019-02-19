<?php

return [

    'directory_list' => [
        'src',
        'test',
        'vendor',
    ],

    'exclude_analysis_directory_list' => [
        'vendor',
    ],

    'progress_bar' => true,

    'strict_method_checking' => true,

    'strict_param_checking' => true,

    'strict_property_checking' => true,

    'strict_return_checking' => true,

    'suppress_issue_types' => [
        'PhanUnreferencedUseNormal',
    ],

    'target_php_version' => null,

];