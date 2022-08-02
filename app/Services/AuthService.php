<?php


namespace App\Services;

use App\Constants\Common;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }



    protected function setModel()
    {
        $this->model = new User();
    }

    public function register(Request $r)
    {
        $input = $r->only(['name', 'phone', 'email', 'password', 'device_id']);
        $user = $this->model->create([
            'phone' => $input['phone'],
            'role' => Common::ROLE_USER,
            'name' => $input['name'],
            'email' => $input['email'],
            'device_id' => $input['device_id'],
            'password' => Hash::make($input['password'])
        ]);

        return $user;
    }

    public function login(Request $r)
    {
        $input = $r->only(['email', 'password']);
        if (Auth::attempt($input) && Auth::user()->status == Common::ACTIVE) {
            return array_merge(
                ['token' => Auth::user()->createToken('passport_token')->accessToken],
                ['infors' => Auth::user()]
            );
        }

        return false;
    }

    public function userDetail()
    {
        return Auth::user();
    }
}
