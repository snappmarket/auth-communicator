<?php

namespace SnappMarket\Auth;

use SnappMarket\Auth\DataContracts\HasPermissionDto;
use SnappMarket\Auth\DataContracts\LoginByUsernameDto;
use SnappMarket\Auth\Exceptions\LoginException;
use SnappMarket\Auth\Responses\LoginResponse;
use SnappMarket\Communicator\Communicator as BasicCommunicator;

class Communicator extends BasicCommunicator
{
    public function __construct(string $baseUri, array $headers = [], ?\Psr\Log\LoggerInterface $logger = null)
    {
        parent::__construct($baseUri, $headers, $logger);
    }

    public function loginByUsername(LoginByUsernameDto $loginByUsernameDto): LoginResponse
    {
        $response = $this->request(self::METHOD_POST, '/api/v1/users/login', [
            'username' => $loginByUsernameDto->getUsername(),
            'password' => $loginByUsernameDto->getPassword(),
        ]);

        if ($response->getStatusCode() != 200) {
            throw new LoginException();
        }

        $data = json_decode($response->getBody()->__toString(), true);

        $response = new LoginResponse();
        $response->setToken($data['results']['token']);
        $response->setUserId($data['results']['user_id']);

        return $response;
    }

    public function hasPermission(HasPermissionDto $userData)
    {
        $response = $this->request(self::METHOD_POST, '/api/v1/auth/hasPermission', [
            'query' => [
                'token' => $userData->getToken(),
                'permission' => $userData->getPermission(),
                'constraint' => $userData->getConstraint()
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new LoginException();
        }

        $data = json_decode($response->getBody()->__toString(), true);

        return $data['results']['authorized'];
    }
}