<?php

namespace App\Http\Middleware;

use App\Support\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin_api')->check()) {
            return $this->respondWithError(message: 'Unauthorized. Kindly Login', status_code: Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
