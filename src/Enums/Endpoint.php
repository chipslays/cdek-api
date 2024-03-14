<?php

namespace Cdek\Enums;

/**
 * @see https://api-docs.cdek.ru/29923918.html
 */
enum Endpoint: string
{
    case PROD = 'https://api.cdek.ru/v2/';
    case DEV = 'https://api.edu.cdek.ru/v2/';
}