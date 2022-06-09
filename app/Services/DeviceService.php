<?php


namespace App\Services;

use App\Models\Device;

class DeviceService extends BaseService
{

    protected function setModel()
    {
        $this->model = new Device();
    }
}
