<?php

namespace App\Services;

use App\Models\Infor;

class InforService extends BaseService
{

    protected function setModel()
    {
        $this->model = new Infor();
    }
}
