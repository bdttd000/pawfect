<?php

require_once 'UserInfo.php';
require_once 'Privilege.php';

class User
{
    private $userId;
    private $privilege;
    private $userInfo;
    private $email;
    private $password;
    private $enabled;
    private $creationDate;

    public function __construct(
        int $userId,
        Privilege $privilege,
        UserInfo $userInfo,
        string $email,
        string $password,
        bool $enabled,
        string $creationDate
    ) {
        $this->userId = $userId;
        $this->privilege = $privilege;
        $this->userInfo = $userInfo;
        $this->email = $email;
        $this->password = $password;
        $this->enabled = $enabled;
        $this->creationDate = $creationDate;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPrivilegeId(): Privilege
    {
        return $this->privilege;
    }

    public function getUserInfo(): UserInfo
    {
        return $this->userInfo;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }
}