<?php

namespace App\Http\Controllers\Api\V2\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource as UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;


class UsersApiController extends Controller
{
    //? Passport
    public function index()
    {
        return response(UserResource::collection(User::all()), '200');
    }

    public function show(User $user)
    {
        return response(new UserResource($user), '200');
    }

    public function getUserByToken(Request $request)
    {
        return response(new UserResource($request->user()), 200);
    }

}
