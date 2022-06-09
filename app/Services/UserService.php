<?php


namespace App\Services;

use App\Models\User;

class UserService extends BaseService
{

    protected function setModel()
    {
        $this->model = new User();
    }
}
