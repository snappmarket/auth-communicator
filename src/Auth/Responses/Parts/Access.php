<?php


namespace SnappMarket\Auth\Responses\Parts;


class Access
{
    /**
     * @var Role
     */
    protected $role;


    /**
     * @var array|Permission[]
     */
    protected $permissions = [];


    /**
     * @var array|Constraint[]
     */
    protected $constraints = [];



    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }



    /**
     * @param Role $role
     */
    public function setRole(Role $role): void
    {
        $this->role = $role;
    }



    /**
     * @return array|Permission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }



    /**
     * @param array|Permission[] $permissions
     */
    public function setPermissions($permissions): void
    {
        $this->permissions = $permissions;
    }



    /**
     * @param Permission $permission
     */
    public function addPermission(Permission $permission): void
    {
        $this->permissions[] = $permission;
    }



    /**
     * @return array|Constraint[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }



    /**
     * @param array|Constraint[] $constraints
     */
    public function setConstraints($constraints): void
    {
        $this->constraints = $constraints;
    }



    /**
     * @param Constraint $constraint
     */
    public function addConstraint(Constraint $constraint): void
    {
        $this->constraints[] = $constraint;
    }
}
