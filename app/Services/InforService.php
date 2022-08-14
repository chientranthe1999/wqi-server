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

    public function _addFilter($r)
    {
        $this->query->with('devices');
        if (isset($r->device_id)) {
            $this->query->where('device_id', $r->device_id);
        }
    }


    public function dashboard($r)
    {
        $deviceId = $r->get('device_id');

        $news = Infor::with('devices')->where('device_id', '=', $deviceId)->orderBy('created_at', 'desc')->firstOrFail();

        $infors = Infor::where('device_id', '=', $deviceId)->select(['wqi', 'created_at'])->limit(20)->orderBy('created_at', 'desc')->get();


        $result =  [
            'newest' => $news,
            'infors' => $infors
        ];

        return $result;
    }
}
