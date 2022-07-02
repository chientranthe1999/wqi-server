<?php

namespace App\Http\Controllers;


use App\Services\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function __construct(DeviceService $service)
    {
        parent::__construct($service);
    }
}
