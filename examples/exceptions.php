<?php

use Cdek\Client;
use GuzzleHttp\Exception\GuzzleException;

require __DIR__ . '/../vendor/autoload.php';

$client = new Client('wrong-id', 'wrong-secret');

try {
    $token = $client->getToken();
} catch (GuzzleException $exception) {
    dd($exception);
}