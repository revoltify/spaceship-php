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

    public function firstName()
    {
        return $this->get('firstName');
    }

    public function lastName()
    {
        return $this->get('lastName');
    }

    public function organization()
    {
        return $this->get('organization');
    }

    public function email()
    {
        return $this->get('email');
    }

    public function address1()
    {
        return $this->get('address1');
    }

    public function address2()
    {
        return $this->get('address2');
    }

    public function city()
    {
        return $this->get('city');
    }

    public function state()
    {
        return $this->get('stateProvince');
    }

    public function countryCode()
    {
        return $this->get('country');
    }

    public function postalCode()
    {
        return $this->get('postalCode');
    }

    public function phone()
    {
        return $this->get('phone');
    }

    public function phoneExt()
    {
        return $this->get('phoneExt');
    }

    public function fax()
    {
        return $this->get('fax');
    }

    public function faxExt()
    {
        return $this->get('faxExt');
    }

    public function taxNumber()
    {
        return $this->get('taxNumber');
    }
}
