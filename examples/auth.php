<?php

use Cdek\Client;

require __DIR__ . '/../vendor/autoload.php';

$client = new Client('EMscd6r9JnFiQ3bLoyjJY6eM78JrJceI', 'PjLZkKBHEiLK3YsjtNrt3TGNG0ahs3kG');

$token = $client->getToken();

dd($token);