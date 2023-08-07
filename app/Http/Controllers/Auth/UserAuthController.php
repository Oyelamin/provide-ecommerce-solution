<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginApiRequest;
use App\Http\Requests\RegisterApiRequest;
use App\Models\User;
use App\Support\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;

class UserAuthController extends Controller
{
    use ResponseTrait;

    public function login(LoginApiRequest $request): JsonResponse
    {
        try {
            // Attempt to authenticate the user
            $credentials = $request->only('email', 'password');
            if (!$accessToken = Auth::attempt($credentials)) {
                throw new AuthenticationException("Unauthorized. Kindly check your credentials.");
            }
            $user = Auth::user();

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

    public function register(RegisterApiRequest $request): JsonResponse
    {
        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone
            ]);
            if(!$user){
                throw new \Exception("Unable to create account. Kindly try again later.");
            }

            // NOTE :: We can trigger an event for email/account verification but that is not important for this test
            return $this->respondWithNoContent( message: "You have successfully register. Kindly proceed to login with your credentials.");

        }catch (\Exception $e){
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

            Auth::guard()->logout();
            return $this->respondWithNoContent(message: "Logged out successfully");

        }catch(\Exception $e){
            return $this->respondWithError(
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }
}
