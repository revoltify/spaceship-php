<?php

declare(strict_types=1);

namespace Spaceship\Params;

use Spaceship\Exception\SpaceshipException;

final class CreateContactParams extends BaseParams
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
            'firstName',
            'lastName',
            'email',
            'address1',
            'city',
            'country',
            'postalCode',
            'phone',
        ];
    }

    /**
     * Set first name
     *
     * @throws SpaceshipException
     */
    public function setFirstName(string $firstName): self
    {
        if (strlen($firstName) > 125
            || strlen($firstName) < 1
        ) {
            throw new SpaceshipException('Invalid first name format');
        }

        return $this->set('firstName', $firstName);
    }

    /**
     * Set last name
     *
     * @throws SpaceshipException
     */
    public function setLastName(string $lastName): self
    {
        if (strlen($lastName) > 125
            || strlen($lastName) < 1
        ) {
            throw new SpaceshipException('Invalid last name format');
        }

        return $this->set('lastName', $lastName);
    }

    /**
     * Set organization name
     *
     * @throws SpaceshipException
     */
    public function setOrganization(string $organization): self
    {
        if (strlen($organization) > 255
        ) {
            throw new SpaceshipException('Invalid organization format');
        }

        return $this->set('organization', $organization);
    }

    /**
     * Set email address
     *
     * @throws SpaceshipException
     */
    public function setEmail(string $email): self
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)
            || strlen($email) > 255
            || strlen($email) < 3
        ) {
            throw new SpaceshipException('Invalid email format');
        }

        return $this->set('email', $email);
    }

    /**
     * Set address line 1
     *
     * @throws SpaceshipException
     */
    public function setAddress1(string $address): self
    {
        if (strlen($address) > 255
        ) {
            throw new SpaceshipException('Invalid address1 format');
        }

        return $this->set('address1', $address);
    }

    /**
     * Set address line 2
     *
     * @throws SpaceshipException
     */
    public function setAddress2(string $address): self
    {
        if (strlen($address) > 255
        ) {
            throw new SpaceshipException('Invalid address2 format');
        }

        return $this->set('address2', $address);
    }

    /**
     * Set city
     *
     * @throws SpaceshipException
     */
    public function setCity(string $city): self
    {
        if (strlen($city) > 255
        ) {
            throw new SpaceshipException('Invalid city format');
        }

        return $this->set('city', $city);
    }

    /**
     * Set country code
     *
     * @param  string  $countryCode  ISO 3166-1 alpha-2 code
     *
     * @throws SpaceshipException
     */
    public function setCountryCode(string $countryCode): self
    {
        if (! preg_match('/^[A-Z]{2}$/', $countryCode)) {
            throw new SpaceshipException('Invalid country code format');
        }

        return $this->set('country', $countryCode);
    }

    /**
     * Set state/province
     *
     * @throws SpaceshipException
     */
    public function setStateProvince(string $stateProvince): self
    {
        if (strlen($stateProvince) > 255
        ) {
            throw new SpaceshipException('Invalid state/province format');
        }

        return $this->set('stateProvince', $stateProvince);
    }

    /**
     * Set postal code
     *
     * @throws SpaceshipException
     */
    public function setPostalCode(string $postalCode): self
    {
        if (strlen($postalCode) > 16
        ) {
            throw new SpaceshipException('Invalid postal code format');
        }

        return $this->set('postalCode', $postalCode);
    }

    /**
     * Set phone number
     *
     * @throws SpaceshipException
     */
    public function setPhone(string $phone): self
    {
        if (! preg_match('/^\+\d{1,3}\.\d{4,}$/', $phone)
            || strlen($phone) > 17
            || strlen($phone) < 7
        ) {
            throw new SpaceshipException('Invalid phone number format');
        }

        return $this->set('phone', $phone);
    }

    /**
     * Set phone extension
     *
     * @throws SpaceshipException
     */
    public function setPhoneExt(string $phoneExt): self
    {
        if (! preg_match('/^\d{0,7}$/', $phoneExt)
            || strlen($phoneExt) > 7
        ) {
            throw new SpaceshipException('Invalid phone extension format');
        }

        return $this->set('phoneExt', $phoneExt);
    }

    /**
     * Set fax number
     *
     * @throws SpaceshipException
     */
    public function setFax(string $fax): self
    {
        if (! preg_match('/^\+\d{1,3}\.\d{4,}$/', $fax)
            || strlen($fax) > 17
            || strlen($fax) < 7
        ) {
            throw new SpaceshipException('Invalid fax number format');
        }

        return $this->set('fax', $fax);
    }

    /**
     * Set fax extension
     *
     * @throws SpaceshipException
     */
    public function setFaxExt(string $faxExt): self
    {
        if (! preg_match('/^\d{0,7}$/', $faxExt)
            || strlen($faxExt) > 7
        ) {
            throw new SpaceshipException('Invalid fax extension format');
        }

        return $this->set('faxExt', $faxExt);
    }

    /**
     * Set tax number
     *
     * @throws SpaceshipException
     */
    public function setTaxNumber(string $taxNumber): self
    {
        if (strlen($taxNumber) > 255
        ) {
            throw new SpaceshipException('Invalid tax number format');
        }

        return $this->set('taxNumber', $taxNumber);
    }
}
