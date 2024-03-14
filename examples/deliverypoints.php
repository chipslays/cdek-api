<?php

use Cdek\Client;

require __DIR__ . '/../vendor/autoload.php';

$client = new Client('EMscd6r9JnFiQ3bLoyjJY6eM78JrJceI', 'PjLZkKBHEiLK3YsjtNrt3TGNG0ahs3kG');

// https://api-docs.cdek.ru/36982648.html
$points = $client->get('deliverypoints', [
    'size' => 10,
]);

foreach ($points as $item) {
    dump($item['name']);
}