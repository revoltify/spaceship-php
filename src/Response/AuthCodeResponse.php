<?php

declare(strict_types=1);

namespace Spaceship\Response;

class AuthCodeResponse extends BaseResponse
{
    public function success(): bool
    {
        if (! empty($this->get('authCode'))) {
            return true;
        }

        return false;
    }

    public function authCode()
    {
        return $this->get('authCode');
    }

    public function expireDate()
    {
        return $this->get('expires');
    }
}
