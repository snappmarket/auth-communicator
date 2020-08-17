<?php

namespace SnappMarket\Auth;

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
        $response->setToken($data['toke']);
        $response->setUserId($data['user_id']);

        return $response;
    }
}