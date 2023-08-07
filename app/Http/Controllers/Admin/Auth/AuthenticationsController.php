<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginApiRequest;
use App\Http\Requests\LoginApiRequest;
use App\Support\Traits\ResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticationsController extends Controller
{
    use ResponseTrait;

    protected static string $guard = 'admin_api';

    public function login(AdminLoginApiRequest $request): JsonResponse
    {
        try {
            // Attempt to authenticate the admin
            $credentials = $request->only('email', 'password');
            if (!$accessToken = Auth::guard(self::$guard)->attempt($credentials)) {
                throw new AuthenticationException("Unauthorized. Kindly check your credentials.");
            }
            $user = Auth::guard(self::$guard)->user();

            $data = [
                'token' => $accessToken,
                'detail' => $user
            ];

            return $this->respondWithCustomData(data: $data);

        }catch(AuthenticationException $e){
            return $this->respondWithError(
                message: $e->getMessage(),
                status_code: Response::HTTP_UNAUTHORIZED
            );
        }catch(\Exception $e){
            return $this->respondWithError(
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try{

            Auth::guard(self::$guard)->logout();
            return $this->respondWithNoContent(message: "Logged out successfully");

        }catch(\Exception $e){
            return $this->respondWithError(
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }
}
