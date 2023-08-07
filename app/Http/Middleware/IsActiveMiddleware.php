<?php

namespace App\Http\Middleware;

use App\Support\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsActiveMiddleware
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('admin_api')->user();
        if(!$user->is_active) return $this->respondWithError(message: 'Unauthorized. Your account is currently inactive. Kindly contact admin to activate.', status_code: Response::HTTP_UNAUTHORIZED);
        return $next($request);
    }
}
