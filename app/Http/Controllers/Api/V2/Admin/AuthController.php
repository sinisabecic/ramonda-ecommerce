<?php

namespace App\Http\Controllers\Api\V2\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function register(Request $request)
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
        $user->assignRole('User');

        $token = $user->createToken('guest-access', ['web', 'registered-from-api']);

        $response = [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];

        return response($response)
            ->setStatusCode(201, 'Created');
    }
}
