<?php

declare (strict_types = 1);

namespace Spaceship\Response;

class UpdateContactResponse extends BaseResponse
{
    public function success(): bool
    {
        if (!empty($this->get('verificationStatus'))) {
            return true;
        }

        return false;
    }

    public function verificationStatus()
    {
        return $this->get('verificationStatus') ?? null;
    }
}
