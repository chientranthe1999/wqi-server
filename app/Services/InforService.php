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

    public function _addFilter()
    {
        $this->query->with('devices');
    }


    public function dashboard()
    {
        $news = Infor::with('devices')->orderBy('created_at', 'desc')->firstOrFail();

        $devices = Device::limit(4)->get();

        $infors = Infor::select(['wqi', 'created_at'])->limit(20)->get();


        $result =  [
            'newest' => $news,
            'devices' => $devices,
            'infors' => $infors
        ];

        return $result;
    }
}
