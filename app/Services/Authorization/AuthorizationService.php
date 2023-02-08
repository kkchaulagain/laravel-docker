<?php

namespace App\Services\Authorization;

use App\Services\BaseService;
use App\Services\Traits\canRespond;
use Exception;

class AuthorizationService extends BaseService
{
    use canRespond;

    public $url;

    public function __construct()
    {
        $this->url = config('services.auth.url');
    }


    public function login(array $data)
    {
        $url = $this->url . '/api/v1/login';
        try {

            $response = $this->sendRequest('POST', $url, $data);

            $statusCode = $response['status_code'];
            $response = json_decode($response['body'], true);
            if ($statusCode !== 200) {
                throw new Exception($response['message'], $statusCode);
            }
            return $this->successResponse($response['data'], $statusCode);
        } catch (Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        }
    }

    public function shadowLogin($id)
    {
        $url = $this->url . '/api/v1/shadowlogin/' . $id;
        $response = $this->sendRequest('POST', $url, []);

        $statusCode = $response['status_code'];
        $response = json_decode($response['body'], true);
        if ($statusCode !== 200) {
            throw new Exception($response['message'], $statusCode);
        }
        return $response['data'];
    }

    public function register(array $data)
    {
        try {
            $response = $this->createUser($data);
            if (!$response['status']) {
                return $this->errorResponse(
                    $response['message'],
                    $response['error'],
                    $response['statusCode']
                );
            }
            return $this->successResponse($response['data'], $response['statusCode']);
        } catch (Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        }
    }

    public function createUser(array $data)
    {

        $url = $this->url . '/api/v1/register';
        try {

            $response = $this->sendRequest('POST', $url, $data);
            $statusCode = $response['status_code'];
            $response = json_decode($response['body'], true);
            if ($statusCode !== 201) {
                $res =  [
                    'status' => false,
                    'statusCode' => $statusCode
                ];
                if (isset($response['error'])) {
                    $res['error'] = $response['error'];
                }
                if (isset($response['message'])) {
                    $res['message'] = $response['message'];
                }
                return $res;
            }
            return [
                'status' => true,
                'data' => $response['data'],
                'statusCode' => $statusCode
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function editUser(array $data)
    {

        $url = $this->url . '/api/v1/update';

        try {

            $response = $this->sendRequest('POST', $url, $data);
            $statusCode = $response['status_code'];
            $response = json_decode($response['body'], true);
            if ($statusCode !== 200) {
                $res =  [
                    'status' => false,
                    'statusCode' => $statusCode
                ];
                if (isset($response['error'])) {
                    $res['error'] = $response['error'];
                }
                if (isset($response['message'])) {
                    $res['message'] = $response['message'];
                }
                return $res;
            }
            return [
                'status' => true,
                'data' => $response['data'],
                'statusCode' => $statusCode
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteUser($id)
    {
        $url = $this->url . '/api/v1/users/' . $id;
        try {

            $response = $this->sendRequest('DELETE', $url);

            $statusCode = $response['status_code'];
            $response = json_decode($response['body'], true);
            if ($statusCode !== 200) {
                return $this->errorResponse(
                    $response['message'],
                    $response['error'],
                    $statusCode
                );
            }
            return  $response['data'];
        } catch (Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        }
    }

    public function users()
    {
        $url = $this->url . '/api/v1/users';
        try {

            $response = $this->sendRequest('GET', $url);

            $statusCode = $response['status_code'];
            $response = json_decode($response['body'], true);
            if ($statusCode !== 200) {
                return $this->errorResponse(
                    $response['message'],
                    $response['error'],
                    $statusCode
                );
            }
            return  $response['data'];
        } catch (Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        }
    }

    public function select($id)
    {
        $url = $this->url . '/api/v1/users/' . $id;
        try {

            $response = $this->sendRequest('GET', $url);

            $statusCode = $response['status_code'];
            $response = json_decode($response['body'], true);
            if ($statusCode !== 200) {
                return $this->errorResponse(
                    $response['message'],
                    $response['error'],
                    $statusCode
                );
            }
            return  $response['data'];
        } catch (Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        }
    }





    public function getUserFromToken($token, $roles)
    {
        try {
            $url = $this->url . '/api/v1/user/hasrole';
            $roles = ['roles' => $roles];
            $response = $this->sendRequest('POST', $url, $roles, $token);
            $statusCode = $response['status_code'];
            if ($statusCode !== 200) {
                throw new \Exception("UnAuthorized", $statusCode);
            }
            $response = json_decode($response['body'], true);
            return $response['data']['user'];
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getTrace(),
                $e->getCode()
            );
        }
    }

    public function forgotPassword(array $data)
    {
        $url = $this->url . '/api/v1/password/forgot';
        try {
            $response = $this->sendRequest('POST', $url, $data);
            $statusCode = $response['status_code'];
            $response = json_decode($response['body'], true);
            if ($statusCode !== 200) {
                throw new \Exception("UnAuthorized", $statusCode);
            }
            return $response['data'];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function resetPassword(array $data)
    {
        $url = $this->url . '/api/v1/password/reset';
        try {
            $response = $this->sendRequest('POST', $url, $data);
            $statusCode = $response['status_code'];
            $response = json_decode($response['body'], true);
            if ($statusCode !== 200) {
                throw new \Exception($response['message'], $statusCode);
            }
            return $response['data'];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function changePassword(array $data, $token)
    {
        $url = $this->url . '/api/v1/password/change';
        try {

            $response = $this->sendRequest('PUT', $url, $data, $token);
            $statusCode = $response['status_code'];
            $response = json_decode($response['body'], true);
            if ($statusCode !== 200) {
                return $this->errorResponse(
                    $response['message'],
                    $response['error'],
                    $statusCode
                );
            }
            return  $response['data'];
        } catch (Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        }
    }
}
