<?php

require_once 'PetInfo.php';

class Pet
{
    private $petId;
    private $userId;
    private $petInfoId;
    private $active;
    private $creationDate;
    private $petInfo;
    private $cityId;
    private $cityName;

    public function __construct(
        int $petId,
        int $userId,
        int $petInfoId,
        bool $active,
        string $creationDate,
        PetInfo $petInfo,
        int $cityId,
        string $cityName
    ) {
        $this->petId = $petId;
        $this->userId = $userId;
        $this->petInfoId = $petInfoId;
        $this->active = $active;
        $this->creationDate = $creationDate;
        $this->petInfo = $petInfo;
        $this->cityId = $cityId;
        $this->cityName = $cityName;
    }

    public function getPetId(): int
    {
        return $this->petId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPetInfoId(): int
    {
        return $this->petInfoId;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function getPetInfo(): PetInfo
    {
        return $this->petInfo;
    }

    public function getCityId(): int
    {
        return $this->cityId;
    }

    public function getCityName(): string
    {
        return $this->cityName;
    }
}