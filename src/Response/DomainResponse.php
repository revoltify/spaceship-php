<?php

declare (strict_types = 1);

namespace Spaceship\Response;

use Spaceship\Enums\NameserverProviders;
use Spaceship\Enums\PrivacyLevel;

class DomainResponse extends BaseResponse
{
    private const EXPIRATION_WARNING_DAYS = 30;

    public function success(): bool
    {
        if (!empty($this->get('name'))) {
            return true;
        }

        return false;
    }

    public function name(): string
    {
        return $this->get('name');
    }

    public function unicodeName(): string
    {
        return $this->get('unicodeName');
    }

    public function isPremium(): bool
    {
        return $this->get('isPremium');
    }

    public function hasAutoRenew(): bool
    {
        return $this->get('autoRenew');
    }

    public function registrationDate(): string
    {
        return $this->get('registrationDate');
    }

    public function registrationDateTime(): \DateTime
    {
        return new \DateTime($this->registrationDate());
    }

    public function expirationDate(): string
    {
        return $this->get('expirationDate');
    }

    public function expirationDateTime(): \DateTime
    {
        return new \DateTime($this->expirationDate());
    }

    public function lifecycleStatus(): string
    {
        return $this->get('lifecycleStatus');
    }

    public function verificationStatus(): string
    {
        return $this->get('verificationStatus');
    }

    public function eppStatuses(): array
    {
        return $this->get('eppStatuses');
    }

    public function hasEppStatus(string $status): bool
    {
        return in_array($status, $this->eppStatuses(), true);
    }

    public function isTransferLocked(): bool
    {
        return $this->hasEppStatus('clientTransferProhibited');
    }

    public function isActive(): bool
    {
        return ! $this->isSuspended();
    }

    public function suspensions(): array
    {
        return $this->get('suspensions');
    }

    public function isSuspended(): bool
    {
        return !empty($this->suspensions());
    }

    public function privacyProtectionLevel(): string
    {
        return $this->get('privacyProtection')['level'] ?? '';
    }

    public function hasContactForm(): bool
    {
        return $this->get('privacyProtection')['contactForm'] ?? false;
    }

    public function hasHighPrivacy(): bool
    {
        return $this->privacyProtectionLevel() === PrivacyLevel::HIGH;
    }

    public function hasPublicPrivacy(): bool
    {
        return $this->privacyProtectionLevel() === PrivacyLevel::HIGH;
    }

    public function nameserverProvider(): string
    {
        return $this->get('nameservers')['provider'] ?? '';
    }

    public function nameserverHosts(): array
    {
        return $this->get('nameservers')['hosts'] ?? [];
    }

    public function hasCustomNameservers(): bool
    {
        return $this->nameserverProvider() === NameserverProviders::CUSTOM;
    }

    public function hasBasicNameservers(): bool
    {
        return $this->nameserverProvider() === NameserverProviders::BASIC;
    }

    public function contacts(): array
    {
        return $this->get('contacts');
    }

    public function getContact(string $type)
    {
        return $this->get('contacts')[$type] ?? null;
    }

    public function getRegistrantId(): string
    {
        return $this->getContact('registrant');
    }

    public function getAdminContactId(): string
    {
        return $this->getContact('admin');
    }

    public function getTechContactId(): string
    {
        return $this->getContact('tech');
    }

    public function getBillingContactId(): string
    {
        return $this->getContact('billing');
    }

    public function contactAttributes(): array
    {
        return $this->get('contacts')['attributes'] ?? [];
    }

    public function isExpired(): bool
    {
        return $this->expirationDateTime() < new \DateTime;
    }

    public function daysUntilExpiration(): int
    {
        $now = new \DateTime;
        $interval = $now->diff($this->expirationDateTime());

        return (int) $interval->format('%R%a');
    }

    public function isExpiringWithin(int $days = self::EXPIRATION_WARNING_DAYS): bool
    {
        $daysLeft = $this->daysUntilExpiration();

        return $daysLeft >= 0 && $daysLeft <= $days;
    }

    public function getDomainAge(): \DateInterval
    {
        $now = new \DateTime;

        return $now->diff($this->registrationDateTime());
    }

    public function getDomainAgeInYears(): float
    {
        return $this->getDomainAge()->y + ($this->getDomainAge()->m / 12) + ($this->getDomainAge()->d / 365);
    }

    public function isVerified(): bool
    {
        return $this->verificationStatus() === 'success';
    }
}
