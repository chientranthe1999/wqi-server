<?php


namespace App\Services;

use App\Constants\Common;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;

class DeviceService extends BaseService
{

    protected function setModel()
    {
        $this->model = new Device();
    }

    public function _addFilter()
    {
        $user = Auth::user();
        if ($user && $user->role == Common::ROLE_USER) {
            $this->query->where('user_id', $user->id);
        }
    }
}
