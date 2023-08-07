<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResource;
use App\Support\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    use ResponseTrait;

    public function __construct()
    {
        $this->resourceItem = UserProfileResource::class;
    }

    /**
     * @return mixed
     */
    public function profile(): mixed
    {
        $user = Auth::user();
        return $this->respondWithItem(item: $user);
    }
}
