<?php

declare(strict_types=1);

namespace Spaceship\Params;

use Spaceship\Enums\PrivacyLevel;
use Spaceship\Exception\SpaceshipException;

final class PrivacyProtectionParams extends BaseParams
{
    /**
     * Static constructor for fluent usage
     *
     * @return static
     */
    public static function make()
    {
        return new self;
    }

    protected function requiredFields(): array
    {
        return [
            'privacyLevel',
            'userConsent',
        ];
    }

    protected function defaultData(): array
    {
        return [
            'userConsent' => true,
        ];
    }

    /**
     * Set Privacy Level
     *
     * @param  string  $level  public|high
     */
    public function setPrivacyLevel(string $level): self
    {
        if (! in_array($level, [PrivacyLevel::PUBLIC, PrivacyLevel::HIGH])) {
            throw new SpaceshipException('Invalid privacy level');
        }

        return $this->set('privacyLevel', $level);
    }
}
