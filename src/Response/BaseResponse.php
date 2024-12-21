<?php

declare(strict_types=1);

namespace Spaceship\Response;

abstract class BaseResponse
{
    /**
     * Response data
     *
     * @var array|null
     */
    protected $response;

    /**
     * @param  array|null  $response  API response data
     */
    public function __construct($response = null)
    {
        $this->response = $response;
    }

    /**
     * Check if the response indicates success
     */
    abstract public function success(): bool;

    /**
     * Get a specific parameter value
     */
    protected function get(string $key, string $default = null)
    {
        return $this->response[$key] ?? $default;
    }

    /**
     * Convert response to array
     */
    public function toArray(): array
    {
        return $this->response ?? [];
    }
}
