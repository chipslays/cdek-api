# PHP CDEK API v2

📦 Минималистичный HTTP-клиент для работы с [API CDEK](https://api-docs.cdek.ru).

## Перед началом работы

Данная библиотека не предоставляет описание методов API, это простой HTTP-клиент который содержит метод авторизации (получение токена) и методы запросов к API.

Вы должны иметь всегда под рукой [документацию от СДЕК](https://api-docs.cdek.ru) для сверки с необходимыми методами.

## Установка


```bash
composer require cdek-php/api
```

## Примеры

Примеры использования библиотеки можно найти в папке [examples](examples).

## Документация

### Авторизация

#### Тестовая среда

```php
use Cdek\Client;

$client = new Client('EMscd6r9JnFiQ3bLoyjJY6eM78JrJceI', 'PjLZkKBHEiLK3YsjtNrt3TGNG0ahs3kG');
```

Пример рабочей тестовой авторизации можно найти в этом [примере](examples/auth.php).

#### Боевая среда

```php
use Cdek\Client;
use Cdek\Enums\Endpoint;

$client = new Client('client-id', 'client-secret', Endpoint::PROD);
```

По умолчанию используется [тестовая среда](https://api-docs.cdek.ru/29923918.html), чтобы начать работать в [боевой среде](https://api-docs.cdek.ru/29923918.html), необхоимо передать параметр `endpoint` со значением `Cdek\Enums\Endpoint::PROD`.

#### Авторизация с помощью `$_ENV`

Библиотека поддерживает авторизация с помощью `$_ENV`, вы можете задать параметры конструктора `client_id`, `client_secret` и `endpoint` например в .env файле приложения.

```bash
# .env
CDEK_API_CLIENT_ID=EMscd6r9JnFiQ3bLoyjJY6eM78JrJceI
CDEK_API_CLIENT_SECRET=PjLZkKBHEiLK3YsjtNrt3TGNG0ahs3kG
CDEK_API_ENDPOINT=dev # dev - тестовая среда, prod - боевая среда
```

```php
// cdek.php

use Cdek\Client;

$client = new Client; // без client_id, client_secret и endpoint
```

Пример авторизации через окружение можно найти в этом [примере](examples/auth-env.php).

### Токен

Токен генерируется при любом запросе к API (они описаны ниже), после чего кэшируется на [указанный в ответе срок](https://api-docs.cdek.ru/29923918.html).

### `getToken(): string`

Возвращает действующий токен.

```php
$token = $client->getToken();
```

### Запросы к API

#### `api(string $method, string $endpoint, array $parameters = []): Collection`

Возвращает объект коллекции ([см. документацию по работе с Laravel коллекцией](https://laravel.com/docs/10.x/collections)).

```php
# https://api-docs.cdek.ru/36982648.html
$client->api('get', 'deliverypoints', [
    'size' => 10,
]);
```

#### `get(string $endpoint, array $parameters = []): Collection`

Выполнить GET-запрос к API.

Возвращает объект коллекции ([см. документацию по работе с Laravel коллекцией](https://laravel.com/docs/10.x/collections)).

```php
# https://api-docs.cdek.ru/36982648.html
$client->get('deliverypoints', [
    'size' => 10,
]);
```

#### `post(string $endpoint, array $parameters = []): Collection`

Выполнить POST-запрос к API.

Возвращает объект коллекции ([см. документацию по работе с Laravel коллекцией](https://laravel.com/docs/10.x/collections)).

```php
$client->post(..., [...]);
```

#### `patch(string $endpoint, array $parameters = []): Collection`

Выполнить PATCH-запрос к API.

Возвращает объект коллекции ([см. документацию по работе с Laravel коллекцией](https://laravel.com/docs/10.x/collections)).

```php
$client->patch(..., [...]);
```

#### `delete(string $endpoint, array $parameters = []): Collection`

Выполнить DELETE-запрос к API.

Возвращает объект коллекции ([см. документацию по работе с Laravel коллекцией](https://laravel.com/docs/10.x/collections)).

```php
$client->delete(..., [...]);
```

## Лицензия

[MIT](https://opensource.org/licenses/MIT).