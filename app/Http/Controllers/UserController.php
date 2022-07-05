<?php

namespace App\Http\Controllers;

use App\Constants\Common;

use App\Services\UserService;

use Laravel\Passport\TokenRepository;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }


    public function logout()
    {
        $access_token = auth()->user()->token();

        // logout from only current device
        $tokenRepository = app(TokenRepository::class);
        $tokenRepository->revokeAccessToken($access_token->id);

        // use this method to logout from all devices
        // $refreshTokenRepository = app(RefreshTokenRepository::class);
        // $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($$access_token->id);

        return response()->json([
            'success' => true,
            'message' => 'User logout successfully.'
        ], 200);
    }


    public function disable($id)
    {
        $role = Auth::user()->role;
        if ($role != Common::ROLE_ADMIN) {
            return $this->respondWithError(ApiCodes::UNAUTHENTICATED, ApiCodes::UNAUTHENTICATED);
        }

        $result = $this->service->disableUser($id);

        if ($result) {
            return $this->respond([
                'item' => $result
            ]);
        }

        return $this->respondWithError(ApiCodes::BAD_REQUEST, ApiCodes::BAD_REQUEST);
    }

    public function active($id)
    {
        $role = Auth::user()->role;
        if ($role != Common::ROLE_ADMIN) {
            return $this->respondWithError(ApiCodes::UNAUTHENTICATED, ApiCodes::UNAUTHENTICATED);
        }

        $result = $this->service->activeUser($id);

        if ($result) {
            return $this->respond([
                'item' => $result
            ]);
        }

        return $this->respondWithError(ApiCodes::BAD_REQUEST, ApiCodes::BAD_REQUEST);
    }

    public function update($id, Request $r)
    {
        $authId = Auth::id();
        $authRole = Auth::user()->role;

        // if(role = 0) || update current user
        if ($id == $authId || $authRole == Common::ROLE_ADMIN) {
            $result = $this->service->updateUser($id, $r);
            if ($result) {
                return $this->respond([
                    'item' => $result
                ]);
            }
        }
        return $this->respondWithError(ApiCodes::BAD_REQUEST, ApiCodes::BAD_REQUEST, 'Please Check again');
    }
}
