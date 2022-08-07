<?php

namespace App\Http\Controllers;

use App\Services\InforService;
use Illuminate\Http\Request;


class InforController extends Controller
{
    public function __construct(InforService $service)
    {
        parent::__construct($service);
    }

    public function dashboard(Request $r)
    {
        try {
            $result = $this->service->dashboard($r);
            return $this->respond(['items' => $result]);
        } catch (Throwable $e) {
            return $this->respondWithError(ApiCodes::UNAUTHENTICATED, ApiCodes::UNAUTHENTICATED, $e->getMessage());
        }
    }
}
