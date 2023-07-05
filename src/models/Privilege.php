<?php

class Privilege
{
    private $privilegeId;
    private $name;

    public function __construct(
        int $privilegeId,
        string $name
    ) {
        $this->privilegeId = $privilegeId;
        $this->name = $name;
    }

    public function getPrivilegeId(): int
    {
        return $this->privilegeId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}