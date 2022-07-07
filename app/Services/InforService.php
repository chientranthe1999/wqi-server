<?php

namespace App\Services;

use App\Models\Infor;
use App\Models\User;
use App\Models\Device;

use Illuminate\Http\Request;


class InforService extends BaseService
{

    protected function setModel()
    {
        $this->model = new Infor();
    }

    public function dashboard() {
        $news = Infor::firstOrFail()->with('devices');

        $devices = Device::limit(4);

        $infors = Infor::select('wqi')->limit(20);


        return [
            'newest' => $news,
            'devices' => $devices,
            'infors' => $infors
        ];
    }
}
