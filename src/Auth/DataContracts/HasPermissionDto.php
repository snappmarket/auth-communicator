<?php


namespace SnappMarket\Auth\DataContracts;


class HasPermissionDto
{
    /** @var string */
    private $token;

    /** @var string */
    private $permission;

    /** @var string|null */
    private $constraint;

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getPermission(): string
    {
        return $this->permission;
    }

    /**
     * @param string $permission
     */
    public function setPermission(string $permission): void
    {
        $this->permission = $permission;
    }

    /**
     * @return string|null
     */
    public function getConstraint(): ?string
    {
        return $this->constraint;
    }

    /**
     * @param string|null $constraint
     */
    public function setConstraint(?string $constraint): void
    {
        $this->constraint = $constraint;
    }
}