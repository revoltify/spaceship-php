<?php

declare (strict_types = 1);

namespace Spaceship\Params;

final class UpdateContactParams extends BaseParams
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
            'registrant',
            'admin',
            'tech',
            'billing',
        ];
    }

    public function setRegistrant(string $registrantId): self
    {
        return $this->set('registrant', $registrantId);
    }

    public function setAdmin(string $adminId): self
    {
        return $this->set('admin', $adminId);
    }

    public function setTech(string $techId): self
    {
        return $this->set('tech', $techId);
    }

    public function setBilling(string $billingId): self
    {
        return $this->set('billing', $billingId);
    }
}
