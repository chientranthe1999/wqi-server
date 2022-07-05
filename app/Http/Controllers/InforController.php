<?php

namespace App\Http\Controllers;

use App\Services\InforService;

class InforController extends Controller
{
    public function __construct(InforService $service)
    {
        parent::__construct($service);
    }
}
