<?php

declare(strict_types=1);

namespace Spaceship\Response;

class ContactResponse extends BaseResponse
{
    public function success(): bool
    {
        if (! empty($this->get('firstName'))) {
            return true;
        }

        return false;
    }

    public function firstName(): string
    {
        return $this->get('firstName');
    }

    public function lastName(): string
    {
        return $this->get('lastName');
    }

    public function organization(): string
    {
        return $this->get('organization');
    }

    public function email(): string
    {
        return $this->get('email');
    }

    public function address1(): string
    {
        return $this->get('address1');
    }

    public function address2(): string
    {
        return $this->get('address2');
    }

    public function city(): string
    {
        return $this->get('city');
    }

    public function state(): string
    {
        return $this->get('stateProvince');
    }

    public function countryCode(): string
    {
        return $this->get('country');
    }

    public function postalCode(): string
    {
        return $this->get('postalCode');
    }

    public function phone(): string
    {
        return $this->get('phone');
    }

    public function phoneExt(): string
    {
        return $this->get('phoneExt');
    }

    public function fax(): string
    {
        return $this->get('fax');
    }

    public function faxExt(): string
    {
        return $this->get('faxExt');
    }

    public function taxNumber(): string
    {
        return $this->get('taxNumber');
    }
}
