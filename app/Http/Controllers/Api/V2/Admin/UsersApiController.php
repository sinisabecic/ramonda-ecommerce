<?php

namespace App\Http\Controllers\Api\V2\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource as UserResource;
use App\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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

    public function store(Request $request)
    {
//      abort_if(!auth()->user()->tokenCan('users-create'), Response::HTTP_FORBIDDEN, 'Unauthorized');

        $inputs = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[A-Za-z0-9_]+$/'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => ['string'],
        ]);


        $user = User::create([
            'account_id' => 1,
            'first_name' => $inputs['first_name'],
            'last_name' => $inputs['last_name'],
            'email' => $inputs['email'],
            'username' => $inputs['username'],
            'password' => $inputs['password'], // There is no need to type Hash::make. In User model watch setPasswordAttribute function.
            'country_id' => 1,
            'address' => $inputs['address'],
        ]);

        $user->photo()->create(['url' => 'user.jpg']);

        $role = Role::findByName('User', 'web');
        $user->assignRole($role);

        $token = $user->createToken('Ramonda Token')->accessToken;

        $response = [
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ];

        return response($response, '201');
//            ->setStatusCode(201, 'Created');
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
