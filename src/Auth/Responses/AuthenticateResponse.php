<?php


namespace SnappMarket\Auth\Responses;


use SnappMarket\Auth\Responses\Parts\Access;

class AuthenticateResponse
{
    /**
     * @var int
     */
    protected $userId;


    /**
     * @var string
     */
    protected $token;


    /**
     * @var array|Access
     */
    protected $accessInfo = [];



    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }



    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }



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
     * @return array|Access
     */
    public function getAccessInfo()
    {
        return $this->accessInfo;
    }



    /**
     * @param array|Access $accessInfo
     */
    public function setAccessInfo($accessInfo): void
    {
        $this->accessInfo = $accessInfo;
    }



    public function addAccess(Access $access): void
    {
        $this->accessInfo[] = $access;
    }
}
