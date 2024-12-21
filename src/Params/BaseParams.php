<?php

declare(strict_types=1);

namespace Spaceship\Params;

use Spaceship\Exception\SpaceshipException;

abstract class BaseParams
{
    /**
     * Data container for parameters
     */
    protected array $data = [];

    /**
     * Static constructor for fluent usage
     *
     * @return static
     */
    abstract public static function make();

    /**
     * Get list of required fields
     */
    abstract protected function requiredFields(): array;

    /**
     * Get default data for parameters
     */
    protected function defaultData(): array
    {
        return [];
    }

    /**
     * Convert parameters to array
     *
     *
     * @throws SpaceshipException When required fields are missing
     */
    public function toArray(): array
    {
        $this->applyDefaultData();
        $this->validateRequiredFields();

        return $this->data;
    }

    /**
     * Apply default data if method exists
     */
    protected function applyDefaultData(): void
    {
        $defaultData = $this->defaultData();
        $this->data = array_merge($defaultData, $this->data);
    }

    /**
     * Validate required fields
     *
     * @throws SpaceshipException When required fields are missing
     */
    protected function validateRequiredFields(): void
    {
        $requiredFields = $this->requiredFields();

        $missingFields = array_filter(
            $requiredFields,
            fn (string $field): bool => ! array_key_exists($field, $this->data)
        );

        if (! empty($missingFields)) {
            throw new SpaceshipException(
                sprintf(
                    'Required fields missing: %s',
                    implode(', ', $missingFields)
                )
            );
        }
    }

    /**
     * Get a specific parameter value
     */
    protected function get(string $key, ?string $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Set a parameter value
     *
     * @return $this
     */
    protected function set(string $key, $value = null)
    {
        if ($value === null) {
            return $this;
        }

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Add a parameter value to an array
     *
     * @return $this
     *
     * @throws SpaceshipException When the key doesn't exist or isn't an array
     */
    protected function add(string $key, $value = null)
    {
        if (! isset($this->data[$key])) {
            $this->data[$key] = [];
        }

        if (! is_array($this->data[$key])) {
            throw new SpaceshipException("Parameter '$key' is not an array");
        }

        $this->data[$key][] = $value;

        return $this;
    }
}
