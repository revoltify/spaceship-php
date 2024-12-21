<?php

declare(strict_types=1);

namespace Spaceship\Params;

use Spaceship\Enums\NameserverProviders;
use Spaceship\Exception\SpaceshipException;

final class NameserverParams extends BaseParams
{
    /**
     * Static constructor for fluent usage
     *
     * @return static
     */
    public static function make(): self
    {
        return new self;
    }

    /**
     * Get the required fields for nameserver configuration
     */
    protected function requiredFields(): array
    {
        return [
            'provider',
            'hosts',
        ];
    }

    /**
     * Set Provider
     *
     * @param  string  $provider  Provider type (custom|basic)
     * @return $this
     *
     * @throws SpaceshipException When provider is invalid
     */
    public function setProvider(string $provider): self
    {
        if (! in_array($provider, [NameserverProviders::CUSTOM, NameserverProviders::BASIC], true)) {
            throw new SpaceshipException('Invalid provider');
        }

        return $this->set('provider', $provider);
    }

    /**
     * Set nameserver hosts
     *
     * @param  array  $hosts  List of nameserver hosts
     * @return $this
     *
     * @throws SpaceshipException When hosts array is associative
     */
    public function setHosts(array $hosts): self
    {
        if (count(array_filter(array_keys($hosts), 'is_string'))) {
            throw new SpaceshipException('The hosts array must not be associative.');
        }

        return $this->set('hosts', $hosts);
    }

    /**
     * Add a single nameserver host
     *
     * @param  string  $host  Nameserver host to add
     * @return $this
     */
    public function addHost(string $host): self
    {
        return $this->add('hosts', $host);
    }
}
