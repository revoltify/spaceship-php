<?php

declare(strict_types=1);

namespace Spaceship\Params;

final class TransferLockParams extends BaseParams
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
            'isLocked',
        ];
    }

    public function lock(): self
    {
        return $this->set('isLocked', true);
    }

    public function unlock(): self
    {
        return $this->set('isLocked', false);
    }
}
