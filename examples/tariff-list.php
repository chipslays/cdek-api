<?php

use Cdek\Client;

require __DIR__ . '/../vendor/autoload.php';

$client = new Client('EMscd6r9JnFiQ3bLoyjJY6eM78JrJceI', 'PjLZkKBHEiLK3YsjtNrt3TGNG0ahs3kG');

// https://api-docs.cdek.ru/63345519.html
$tariffs = $client->post('calculator/tarifflist', [
    'from_location' => ['code' => 248],
    'to_location' => ['code' => 250],
    'packages' => ['weight' => 5000],
]);

dd($tariffs);