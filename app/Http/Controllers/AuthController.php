<?php

namespace App\Http\Controllers;

use App\Constants\ApiCodes;
use App\Constants\Common;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use Laravel\Passport\TokenRepository;
use App\Http\Requests\RegisterRequest;
use Throwable;

class AuthController extends Controller
{
    public function __construct(AuthService $service)
    {
        parent::__construct($service);
    }

    /**
     * Register a new user
     * @return json
     */

    public function register(RegisterRequest $r)
    {
        try {
            $result = $this->service->register($r);

            if ($result) {
                return $this->respond($result, 'Register successfullly');
            }

            return $this->respondWithError(ApiCodes::UNAUTHENTICATED, ApiCodes::UNAUTHENTICATED, 'Register failed');
        } catch (Throwable $e) {
            return $this->respondWithError(ApiCodes::UNAUTHENTICATED, ApiCodes::UNAUTHENTICATED, $e->getMessage());
        }
    }

    /**
     * Login user.
     * @return json
     */
    public function login(LoginRequest $r)
    {
        $result = $this->service->login($r);

        if ($result) {
            return $this->respond([
                'item' => $result,
                'message' => 'Login successfullly'
            ]);
        }

        return $this->respondWithError(ApiCodes::UNAUTHENTICATED, ApiCodes::UNAUTHENTICATED, 'Login failed');
    }

    /**
     * Return user information
     *
     * @return json
     */
    public function userDetail()
    {
        return $this->respond($this->service->userDetail());
    }

    /**
     * Update user information
     */

    public function updateUser(Request $r)
    {
        return $this->respond($this->service->updateUser($r));
    }



    /**
     * disable user
     */

    public function disableUser(Request $r)
    {
        $userRole = Auth::user()->role;

        if ($userRole != Common::ROLE_ADMIN) {
            return $this->respondWithError(ApiCodes::FORBIDDEN_EXCEPTION, ApiCodes::FORBIDDEN_EXCEPTION, 'You don\'t have permission to do this');
        }

        return $this->respond($this->service->disableUser($r));
    }


    /**
     * active user
     */

    public function activeUser(Request $r)
    {
        // TODO: Move to middleware
        $userRole = Auth::user()->role;

        if ($userRole != Common::ROLE_ADMIN) {
            return $this->respondWithError(ApiCodes::FORBIDDEN_EXCEPTION, ApiCodes::FORBIDDEN_EXCEPTION, 'You don\'t have permission to do this');
        }
        return $this->respond($this->service->activeUser($r));
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
}
