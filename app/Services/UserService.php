<?php


namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;

class UserService extends BaseService
{
    public function __construct(Request $r)
    {
        parent::__construct($r);
    }



    protected function setModel()
    {
        $this->model = new User();
    }

    /**
     * Change user infor
     */

    public function updateUser(Request $r)
    {

        // can move to
        $authId = Auth::user()->id;
        $authRole = Auth::user()->role;
        // if(role = 0) || update current user

        $id = $r->input('id');

        if ($r->input('id') == $authId || $authRole == 0) {
            $input = $r->only(['name', 'phone', 'email', 'password']);
            $user = $this->model->find($id);
            if (!$user) {
                // TODO: Can throw exception
                return false;
            }
            $user->create($input);
            return $user;
        }
    }
}
