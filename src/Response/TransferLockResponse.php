<?php

declare(strict_types=1);

namespace Spaceship\Response;

class TransferLockResponse extends BaseResponse
{
    public function success(): bool
    {
        return ! empty($this->get('isLocked'));
    }
}
