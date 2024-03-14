<?php

// somewhere like: .env
$_ENV['CDEK_API_CLIENT_ID'] = 'EMscd6r9JnFiQ3bLoyjJY6eM78JrJceI';
$_ENV['CDEK_API_CLIENT_SECRET'] = 'PjLZkKBHEiLK3YsjtNrt3TGNG0ahs3kG';
$_ENV['CDEK_API_ENDPOINT'] = 'dev'; // Can be `prod` or `dev`.

// file: cdek.php
use Cdek\Client;

require __DIR__ . '/../vendor/autoload.php';

$client = new Client;

$token = $client->getToken();

dd($token);