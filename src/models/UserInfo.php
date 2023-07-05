<?php

class UserInfo
{
    private $userInfoId;
    private $name;
    private $surname;
    private $phone;
    private $address;
    private $cityId;
    private $cityName;

    public function __construct(
        int $userInfoId,
        string $name,
        string $surname,
        string $phone,
        string $address,
        int $cityId,
        string $cityName
    ) {
        $this->userInfoId = $userInfoId;
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
        $this->address = $address;
        $this->cityId = $cityId;
        $this->cityName = $cityName;
    }

    public function getUserInfoId(): int
    {
        return $this->userInfoId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCityId(): string
    {
        return $this->cityId;
    }

    public function getCityName(): string
    {
        return $this->cityName;
    }
}