#!/usr/bin/env php
<?php

$sslVersions = [
    CURL_SSLVERSION_DEFAULT,
    CURL_SSLVERSION_TLSv1,
    CURL_SSLVERSION_TLSv1_0,
    CURL_SSLVERSION_TLSv1_1,
    CURL_SSLVERSION_TLSv1_2,
    CURL_SSLVERSION_SSLv2,
    CURL_SSLVERSION_SSLv3,
];

var_dump(curl_version());

foreach ($sslVersions as $sslVersion) {

    $uri = "https://api.reporting.cloud";

    printf("Trying %d", $sslVersion);
    echo PHP_EOL;

    $curl = curl_init($uri);

    //curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
    curl_setopt($curl, CURLOPT_SSLVERSION     , $sslVersion);
    curl_setopt($curl, CURLOPT_VERBOSE        , true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER , 1);

    if (curl_exec($curl) === false) {
        var_dump(curl_error($curl));
    } else {
        curl_close($curl);
    }

    echo PHP_EOL . PHP_EOL;

}

exit(1);