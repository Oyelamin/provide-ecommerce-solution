<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Http\Resources\UserProfileResource;
use App\Support\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministratorsController extends Controller
{
    use ResponseTrait;
    protected static string $guard = 'admin_api';

    public function __construct()
    {
        $this->resourceItem = AdminResource::class;
    }

    /**
     * @return mixed
     */
    public function profile(): mixed
    {
        $user = Auth::guard(self::$guard)->user();
        return $this->respondWithItem(item: $user);
    }


}
