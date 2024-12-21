<?php

declare(strict_types=1);

namespace Spaceship\Response;

class CreateContactResponse extends BaseResponse
{
    public function success(): bool
    {
        if (! empty($this->get('contactId'))) {
            return true;
        }

        return false;
    }

    public function contactId(): string
    {
        return $this->get('contactId');
    }
}
