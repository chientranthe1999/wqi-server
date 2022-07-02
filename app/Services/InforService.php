<?php

namespace App\Services;

use App\Models\Infor;
use Illuminate\Http\Request;


class InforService extends BaseService
{

    protected function setModel()
    {
        $this->model = new Infor();
    }

    public function store(array $attributes = [], Request $r)
    {

        // caculate wqi
    }
}
