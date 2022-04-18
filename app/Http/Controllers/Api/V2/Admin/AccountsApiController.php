<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountsApiController extends Controller
{
    public function index()
    {
        return AccountResource::collection(Account::all());
    }

    public function store(Request $request)
    {
//        $account = Account::create($request->all());
        $account = new Account();
        $account->save([
            $account->name = $request->input('name'),
        ]);

        return response()
            ->json($account)
            ->setStatusCode(201, 'Created');

//        return (new AccountResource($account))
//            ->response($account)
//            ->setStatusCode(201, 'Created');
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return response()
            ->json()
            ->setStatusCode(204, 'Deleted');
    }
}
