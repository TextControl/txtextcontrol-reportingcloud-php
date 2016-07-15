<?php

$ch = curl_init("https://api.reporting.cloud");

curl_setopt($ch, CURLOPT_VERBOSE        , true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
curl_setopt($ch, CURLOPT_SSLVERSION     , 5);

if (curl_exec($ch) === false) {
    var_dump(curl_error($ch));
} else {
    curl_close($ch);
}
