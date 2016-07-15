#!/usr/bin/env php
<?php

for ($x = 0; $x <= 10; $x++) {

    printf("Trying %d", $x);
    echo PHP_EOL;

    $ch = curl_init("https://api.reporting.cloud");

    curl_setopt($ch, CURLOPT_VERBOSE        , true);
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
    curl_setopt($ch, CURLOPT_SSLVERSION     , $x);

    if (curl_exec($ch) === false) {
        var_dump(curl_error($ch));
    } else {
        curl_close($ch);
    }

    echo PHP_EOL;
    echo PHP_EOL;

}



