<?php

namespace App\Http\Controllers;

use App\Services\InforService;

class InforController extends Controller
{
    public function __construct(InforService $service)
    {
        parent::__construct($service);
    }

    public function dashboard() {
        try{

            return $this->respond($this->service->dashboard());
        } catch(Throwable $e) {
            return $this->respondWithError(ApiCodes::UNAUTHENTICATED, ApiCodes::UNAUTHENTICATED, $e->getMessage());
        }
    }
}
