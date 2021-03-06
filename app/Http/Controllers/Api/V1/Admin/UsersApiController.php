<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource as UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;


class UsersApiController extends Controller
{

    public function index()
    {
        abort_if(!auth()->user()->tokenCan('users-list'), Response::HTTP_FORBIDDEN, 'Unauthorized');
//        if (!auth()->user()->tokenCan('users-list')) {
//            abort(403, 'Unauthorized');
//        }

        //token: 14|HGoGAOL9BRrqzwxGSeS6MtCm1BigjsfvKDGScLP8

        return UserResource::collection(User::all())
            ->response()
            ->setStatusCode(200, 'OK');
    }

    public function show($id)
    {
//        if (!auth()->user()->tokenCan('users-show')) {
//            abort(403, 'Unauthorized');
//        }
        abort_if(!auth()->user()->tokenCan('users-show'), Response::HTTP_FORBIDDEN, 'Unauthorized');
        //token: 8|CsEIuXl37WvANwD9hZCsanqlqx4iMgKeNqYxq0iF

        return UserResource::collection(User::where('id', $id)->get())
            ->response()
            ->setStatusCode('200', 'OK');
    }
}
