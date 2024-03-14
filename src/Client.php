<?php

namespace Cdek;

use Cdek\Enums\Endpoint;
use Cdek\Exceptions\CdekException;
use Illuminate\Support\Collection;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * @see https://api-docs.cdek.ru
 */
class Client
{
    protected GuzzleHttpClient $httpClient;

    /**
     * Client constructor.
     *
     * @param string $id
     * @param string $secret
     * @param Endpoint $endpoint
     */
    public function __construct(
        protected ?string $id = null,
        protected ?string $secret = null,
        protected Endpoint $endpoint = Endpoint::DEV,
    ) {
        if (isset($_ENV['CDEK_API_CLIENT_ID']) && $value = $_ENV['CDEK_API_CLIENT_ID']) {
            $this->id = $value;
        }

        if (isset($_ENV['CDEK_API_CLIENT_SECRET']) && $value = $_ENV['CDEK_API_CLIENT_SECRET']) {
            $this->secret = $value;
        }

        if (isset($_ENV['CDEK_API_ENDPOINT']) && $value = $_ENV['CDEK_API_ENDPOINT']) {
            $this->endpoint = match ($value) {
                'dev', 'devlopment' => Endpoint::DEV,
                'prod', 'production' => Endpoint::PROD,
                default => throw new CdekException('Unknown CDEK API endpoint: ' . $value),
            };
        }

        $this->createHttpClient();
    }

    public function createHttpClient(): void
    {
        $httpClientConfig = [
            'base_uri' => $this->endpoint->value,
            'defaults' => [
                'headers' => [
                    'content-type' => 'application/json',
                ],
            ],
        ];

        $this->httpClient = new GuzzleHttpClient($httpClientConfig);
    }

    /**
     * Get token from cache or API (and save it to cache).
     *
     * @return string
     */
    public function getToken(): string
    {
        $fileCache = new FilesystemAdapter('cdek-api');

        $cacheKey = hash('sha256', $this->id . $this->secret . $this->endpoint->value);

        $token = $fileCache->get($cacheKey, function(ItemInterface $item) {
            $parameters = [
                'grant_type' => 'client_credentials',
                'client_id' => $this->id,
                'client_secret' => $this->secret,
            ];

            $response = $this->httpClient->request('post','oauth/token', [
                'form_params' => $parameters,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            $item->set($result['access_token']);
            $item->expiresAfter($result['expires_in']);

            return $result['access_token'];
        });

        return $token;
    }

    /**
     * Send request to CDEK API and return result as Collection object.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $parameters
     * @return Collection
     *
     * @throws GuzzleException
     */
    public function api(string $method, string $endpoint, array $parameters = []): Collection
    {
        $body = in_array(strtolower($method), ['get', 'delete']) ? 'query' : 'json';

        $response = $this->httpClient->request($method, $endpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getToken(),
            ],
            $body => $parameters
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return new Collection($result);
    }

    /**
     * Send GET request to CDEK API and return result as Collection object.
     *
     * @param string $endpoint
     * @param array $parameters
     * @return Collection
     *
     * @throws GuzzleException
     */
    public function get(string $endpoint, array $parameters = []): Collection
    {
        return $this->api(__FUNCTION__, ...func_get_args());
    }

    /**
     * Send POST request to CDEK API and return result as Collection object.
     *
     * @param string $endpoint
     * @param array $parameters
     * @return Collection
     *
     * @throws GuzzleException
     */
    public function post(string $endpoint, array $parameters = []): Collection
    {
        return $this->api(__FUNCTION__, ...func_get_args());
    }

    /**
     * Send PATCH request to CDEK API and return result as Collection object.
     *
     * @param string $endpoint
     * @param array $parameters
     * @return Collection
     *
     * @throws GuzzleException
     */
    public function patch(string $endpoint, array $parameters = []): Collection
    {
        return $this->api(__FUNCTION__, ...func_get_args());
    }

    /**
     * Send DELETE request to CDEK API and return result as Collection object.
     *
     * @param string $endpoint
     * @param array $parameters
     * @return Collection
     *
     * @throws GuzzleException
     */
    public function delete(string $endpoint, array $parameters = []): Collection
    {
        return $this->api(__FUNCTION__, ...func_get_args());
    }
}