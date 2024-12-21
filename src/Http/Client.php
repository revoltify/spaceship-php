<?php

declare(strict_types=1);

namespace Spaceship\Http;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Spaceship\Constants\Endpoints;
use Spaceship\Exception\SpaceshipException;

final class Client
{
    private HttpClient $client;

    private string $apiKey;

    private string $apiSecret;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->client = new HttpClient([
            'base_uri' => Endpoints::BASE_URL,
            'timeout' => 10,
        ]);
    }

    /**
     * Send HTTP request to the API
     *
     * @param  string  $method  HTTP method
     * @param  string  $endpoint  API endpoint
     * @param  array  $options  Additional request options
     * @return array|null Response data (null for 204 responses)
     *
     * @throws SpaceshipException If the request fails
     */
    private function sendRequest(string $method, string $endpoint, array $options): ?array
    {
        try {
            $options['headers'] = [
                'X-API-Key' => $this->apiKey,
                'X-API-Secret' => $this->apiSecret,
                'Content-type' => 'application/json',
            ];

            $response = $this->client->request($method, $endpoint, $options);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 204) {
                return null;
            }

            if ($response->getStatusCode() !== 200) {
                $this->handleHttpError($response);
            }

            return json_decode((string) $response->getBody(), true);

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorDetail = $this->extractErrorDetails($e->getResponse());
                throw new SpaceshipException($errorDetail);
            }
            throw new SpaceshipException('Network error: '.$e->getMessage());
        } catch (GuzzleException $e) {
            throw new SpaceshipException('Connection error: '.$e->getMessage());
        } catch (SpaceshipException $e) {
            throw new SpaceshipException($e->getMessage());
        } catch (\Exception $e) {
            throw new SpaceshipException('Unexpected error: '.$e->getMessage());
        }
    }

    /**
     * Extract error details from a problem+json response
     *
     * @param  ResponseInterface  $response  Response containing error details
     * @return string Error detail message
     */
    private function extractErrorDetails(ResponseInterface $response): string
    {
        $body = (string) $response->getBody();

        /** @var array<string, mixed>|null */
        $errorData = json_decode($body, true);

        if (isset($errorData['detail'])) {
            return (string) $errorData['detail'];
        }

        return 'An error occurred with status code '.$response->getStatusCode();
    }

    /**
     * Handles HTTP error responses based on the status code
     *
     * @param  ResponseInterface  $response  The response object containing the error
     *
     * @throws SpaceshipException
     */
    private function handleHttpError(ResponseInterface $response): void
    {
        $statusCode = $response->getStatusCode();
        $errorDetail = $this->extractErrorDetails($response);

        $errors = [
            400 => 'Bad request: '.$errorDetail,
            401 => 'Unauthorized: '.$errorDetail,
            404 => 'Not Found: '.$errorDetail,
            429 => $this->buildRateLimitMessage($response, $errorDetail),
            500 => 'Server error: '.$errorDetail,
        ];

        $message = $errors[$statusCode] ?? 'Unexpected HTTP status code '.$statusCode.': '.$errorDetail;

        throw new SpaceshipException($message);
    }

    /**
     * Build rate limit error message with retry information
     *
     * @param  ResponseInterface  $response  Response containing rate limit headers
     * @param  string  $errorDetail  Base error message
     * @return string Complete rate limit error message
     */
    private function buildRateLimitMessage(ResponseInterface $response, string $errorDetail): string
    {
        $rateLimitInfo = $response->getHeaders();
        $retryAfter = $rateLimitInfo['Retry-After'][0] ?? '300';

        return sprintf(
            'Rate limit exceeded. Retry after: %s seconds. %s',
            $retryAfter,
            $errorDetail
        );
    }

    /**
     * Send GET request to the specified endpoint
     *
     * @param  string  $endpoint  API endpoint
     * @param  array|null  $data  Query parameters
     * @return array|null Response data
     *
     * @throws SpaceshipException
     */
    public function get(string $endpoint, array $data = [])
    {
        return $this->sendRequest('GET', $endpoint, ['query' => $data]);
    }

    /**
     * Send POST request to the specified endpoint
     *
     * @param  string  $endpoint  API endpoint
     * @param  array|null  $data  Request body data
     * @return array|null Response data
     *
     * @throws SpaceshipException
     */
    public function post(string $endpoint, array $data = [])
    {
        return $this->sendRequest('POST', $endpoint, ['json' => $data]);
    }

    /**
     * Send PUT request to the specified endpoint
     *
     * @param  string  $endpoint  API endpoint
     * @param  array|null  $data  Request body data
     * @return array|null Response data
     *
     * @throws SpaceshipException
     */
    public function put(string $endpoint, array $data = [])
    {
        return $this->sendRequest('PUT', $endpoint, ['json' => $data]);
    }

    /**
     * Send DELETE request to the specified endpoint
     *
     * @param  string  $endpoint  API endpoint
     * @param  array|null  $data  Request body data
     * @return array|null Response data
     *
     * @throws SpaceshipException
     */
    public function delete(string $endpoint, array $data = [])
    {
        return $this->sendRequest('DELETE', $endpoint, ['json' => $data]);
    }
}
