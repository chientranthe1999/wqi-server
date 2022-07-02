<?php

namespace App\Http\Controllers;

use App\Constants\ApiCodes;
use App\Http\ResponseBuilder\ResponseBuilder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * @throws InvalidTypeException
     * @throws NotIntegerException
     * @throws IncompatibleTypeException
     * @throws ConfigurationNotFoundException
     * @throws ArrayWithMixedKeysException
     * @throws MissingConfigurationKeyException
     */
    public function respond($data = null, $msg = null): Response
    {
        return ResponseBuilder::asSuccess()->withData($data)->withMessage($msg)->build();
    }

    /**
     * @throws InvalidTypeException
     * @throws NotIntegerException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws ArrayWithMixedKeysException
     * @throws MissingConfigurationKeyException
     */
    public function respondWithError($api_code, $http_code, $message = ''): Response
    {
        return ResponseBuilder::asError($api_code)->withMessage($message)->withHttpCode($http_code)->build();
    }

    /**
     * @throws InvalidTypeException
     * @throws NotIntegerException
     * @throws ArrayWithMixedKeysException
     * @throws MissingConfigurationKeyException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     */
    public function respondBadRequest($api_code): Response
    {
        return $this->respondWithError($api_code, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @throws InvalidTypeException
     * @throws NotIntegerException
     * @throws ArrayWithMixedKeysException
     * @throws MissingConfigurationKeyException
     * @throws IncompatibleTypeException
     * @throws ConfigurationNotFoundException
     */
    public function respondUnAuthorizedRequest($api_code): Response
    {
        return $this->respondWithError($api_code, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @throws InvalidTypeException
     * @throws NotIntegerException
     * @throws ArrayWithMixedKeysException
     * @throws MissingConfigurationKeyException
     * @throws IncompatibleTypeException
     * @throws ConfigurationNotFoundException
     */
    public function respondNotFound($message = ''): Response
    {
        return $this->respondWithError(ApiCodes::HTTP_NOT_FOUND, Response::HTTP_NOT_FOUND, $message);
    }

    /**
     * @throws InvalidTypeException
     * @throws NotIntegerException
     * @throws ArrayWithMixedKeysException
     * @throws MissingConfigurationKeyException
     * @throws IncompatibleTypeException
     * @throws ConfigurationNotFoundException
     */
    public function respondForbidden(): Response
    {
        return $this->respondWithError(ApiCodes::FORBIDDEN_EXCEPTION, Response::HTTP_FORBIDDEN);
    }

    public function index(Request $r): Response
    {
        try {
            return $this->respond($this->service->index($r));
        } catch (\Exception $e) {
            return $this->respondWithError(ApiCodes::SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }


    /**
     * @param Request $r
     * @return Response
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $r): Response
    {
        try {
            if (method_exists($this, '_addValidate')) {
                $this->_addValidate($r);
            }
            DB::beginTransaction();
            $result = $this->service->store();
            DB::commit();
            return $this->respond($result);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
