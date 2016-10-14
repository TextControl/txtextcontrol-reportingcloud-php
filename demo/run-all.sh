#!/usr/bin/env bash
clear
for file in *.php;
do
    echo "Running $file..."
    php $file;
    printf "\n"
done