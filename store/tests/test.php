<?php
require '../vendor/autoload.php';

$col = collect(['sda', 'abu', null])
    ->map(function ($name) {
        return strtoupper($name);
    })
    ->reject(function ($name) {
        return empty($name);
    });

dump($col);
