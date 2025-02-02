<?php

/**
 * Copyright (c) D3 Data Development (Inh. Thomas Dartsch)
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <info@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

declare(strict_types=1);

namespace D3\KlicktippPhpClient;

use Assert\Assert;
use Composer\InstalledVersions;
use D3\KlicktippPhpClient\Exceptions\CommunicationException;
use D3\KlicktippPhpClient\Exceptions\NoCredentialsException;
use D3\KlicktippPhpClient\Exceptions\ResponseContentException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class Connection
{
    public const URL = 'https://api.klicktipp.com/';

    public const USERAGENT = 'Klicktipp-php-client';

    protected string $client_key;

    protected string $secret_key;

    protected CookieJar $cookies_jar;

    /**
     * Contains the HTTP client (e.g. Guzzle)
     */
    private ClientInterface $client;

    public function __construct(string $client_key, string $secret_key)
    {
        Assert::lazy()
            ->setExceptionClass(NoCredentialsException::class)
            ->that($client_key, 'client_key')
            ->notBlank()
            ->that($secret_key, 'secret_key')
            ->notBlank()
            ->verifyNow();

        $this->client_key = trim($client_key);
        $this->secret_key = trim($secret_key);
        $this->cookies_jar = new CookieJar();
    }

    public function getClientKey(): string
    {
        return $this->client_key;
    }

    public function getSecretKey(): string
    {
        return $this->secret_key;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        $this->client ??=
            new Client([
                'base_uri' => self::URL,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'User-Agent' => self::USERAGENT.'/'.InstalledVersions::getVersion('d3/klicktipp-php-client'),
                ],
            ]);

        return $this->client;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @return ResponseInterface
     * @throws CommunicationException
     * @throws ResponseContentException
     */
    public function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        try {
            $options['query'] ??= [];
            $options[RequestOptions::COOKIES] = $this->getCookiesJar();

            if (! empty($options['body'])) {
                $options['body'] = json_encode($options['body']);
            }

            return $this->getClient()->request($method, $uri, $options);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->parseResponse($e->getResponse());
            }

            throw new CommunicationException(
                $e->getResponse()->getBody(),
                $e->getResponse()->getStatusCode(),
                $e
            );
        } catch (GuzzleException $e) {
            throw new CommunicationException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return array
     * @throws ResponseContentException
     * @throws CommunicationException
     */
    public function requestAndParse(string $method, string $uri, array $options = []): array
    {
        return $this->parseResponse($this->request($method, $uri, $options));
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array Parsed JSON result
     * @throws ResponseContentException
     */
    public function parseResponse(ResponseInterface $response): array
    {
        // Rewind the response (middlewares might have read it already)
        $response->getBody()->rewind();

        $response_body = $response->getBody()->getContents();

        $result_array = json_decode($response_body, true);

        if ($response->getStatusCode() === 204) {
            return [];
        }

        Assert::lazy()
            ->setExceptionClass(ResponseContentException::class)
            ->that($result_array)
            ->isArray(sprintf('%s: %s', $response->getStatusCode(), $response_body))
            ->verifyNow();

        return $result_array;
    }

    public function getCookiesJar(): CookieJar
    {
        return $this->cookies_jar;
    }
}
