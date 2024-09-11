<?php

namespace App\Models;

class Address
{
    public function __construct(
        private string $street,
        private string $city,
        private string $country,
        private string $postal_code,
    ) {
        $this->street = $street;
        $this->city = $city;
        $this->country = $country;
        $this->postal_code = $postal_code;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $value,): void
    {
        $this->street = $value;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $value,): void
    {
        $this->city = $value;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $value,): void
    {
        $this->country = $value;
    }

    public function getPostalCode(): string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $value,): void
    {
        $this->postal_code = $value;
    }

    function __tostring(): string
    {
        return "{$this->getStreet()}, {$this->getCity()}, {$this->getCountry()}, {$this->getPostalCode()}";
    }
}
