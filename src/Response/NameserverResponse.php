<?php

declare(strict_types=1);

namespace Spaceship\Response;

use Spaceship\Enums\NameserverProviders;

class NameserverResponse extends BaseResponse
{
    public function success(): bool
    {
        if (! empty($this->get('provider')) && $this->get('hosts')) {
            return true;
        }

        return false;
    }

    public function nameserverProvider(): string
    {
        return $this->get('provider');
    }

    public function nameserverHosts(): array
    {
        return $this->get('hosts');
    }

    public function hasCustomNameservers(): bool
    {
        return $this->nameserverProvider() === NameserverProviders::CUSTOM;
    }

    public function hasBasicNameservers(): bool
    {
        return $this->nameserverProvider() === NameserverProviders::BASIC;
    }
}
