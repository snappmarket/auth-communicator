<?php

namespace SnappMarket\Auth;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use SnappMarket\Auth\DataContracts\HasAllPermissionsDto;
use SnappMarket\Auth\DataContracts\HasPermissionDto;
use SnappMarket\Auth\DataContracts\LoginByUsernameDto;
use SnappMarket\Auth\Exceptions\InvalidTokenException;
use SnappMarket\Auth\Exceptions\LoginException;
use SnappMarket\Auth\Responses\AuthenticateResponse;
use SnappMarket\Auth\Responses\LoginResponse;
use SnappMarket\Auth\Responses\Parts\Access;
use SnappMarket\Auth\Responses\Parts\Constraint;
use SnappMarket\Auth\Responses\Parts\Permission;
use SnappMarket\Auth\Responses\Parts\Role;
use SnappMarket\Communicator\Communicator as BasicCommunicator;

class Communicator extends BasicCommunicator
{
    const INVALID_TOKEN_CODE = 13;



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



    public function authenticate(string $token)
    {
        $response = $this->request(self::METHOD_POST, '/api/v1/users/authenticate', compact('token'));
        $data     = json_decode($response->getBody()->__toString(), true);
        $results  = $data['results'];

        $responseDto = new AuthenticateResponse;
        $responseDto->setUserId($results['user_id']);
        $responseDto->setToken($results['token']);

        foreach ($results['access_info'] as $accessInfoItem) {
            $access = new Access();

            $accessRole = new Role;
            $accessRole->setId($accessInfoItem['role']['id']);
            $accessRole->setName($accessInfoItem['role']['name']);
            $access->setRole($accessRole);

            foreach ($accessInfoItem['permissions'] as $permissionInfo) {
                $permission = new Permission;
                $permission->setId($permissionInfo['id']);
                $permission->setTitle($permissionInfo['title']);
                $access->addPermission($permission);
            }

            foreach ($accessInfoItem['constraints'] as $constraintInfo) {
                $constraint = new Constraint;
                $constraint->setCode($constraintInfo['code']);
                $constraint->setValue($constraintInfo['value']);
                $access->addConstraint($constraint);
            }


            $responseDto->addAccess($access);
        }

        return $responseDto;
    }



    public function hasAllPermissions(HasAllPermissionsDto $userData)
    {
        $response = $this->request(self::METHOD_GET, '/api/v1/auth/hasAllPermissions', [
             'token'       => $userData->getToken(),
             'permissions' => $userData->getPermissions(),
             'constraints' => $userData->getConstraints(),
        ]);

        $data = json_decode($response->getBody()->__toString(), true);

        return $data['results']['authorized'];
    }



    public function logout(string $token)
    {
        $this->request(self::METHOD_GET, '/api/v1/users/logout', compact('token'));
    }



    public function request(string $method, string $uri, array $parameters = [], array $headers = []): ResponseInterface
    {
        try {
            $response = parent::request($method, $uri, $parameters, $headers);
        } catch (RequestException $exception) {
            if ($this->getRequestFailureErrorCode($exception) == static::INVALID_TOKEN_CODE) {
                throw new InvalidTokenException();
            }

            throw $exception;
        }

        return $response;
    }



    protected function getRequestFailureErrorCode(RequestException $exception): ?string
    {
        $response = $exception->getResponse();

        if ($exception->getResponse()->getStatusCode() == 200) {
            return null;
        }

        $data = json_decode($response->getBody()->__toString(), true);

        return $data['error_code'] ?? null;
    }
}
