<?php


namespace SnappMarket\Auth\DataContracts;


class HasAllPermissionsDto
{
    /** @var string */
    private $token;

    /** @var array */
    private $permissions = [];

    /** @var array */
    private $constraints = [];

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
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }



    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions): void
    {
        $this->permissions = $permissions;
    }

    


    /**
     * @return array
     */
    public function getConstraints(): array
    {
        return $this->constraints;
    }



    /**
     * @param array $constraints
     */
    public function setConstraints(array $constraints): void
    {
        $this->constraints = $constraints;
    }


}
