<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __invoke()
    {
//        if (auth()->user()->hasRole('Admin')) {
//            return view('admin.home');
//        } else {
//            abort(403, 'You are not authorized!');
//        }
        abort_if(!auth()->user()->hasRole('Admin'), 403, 'You are not authorized!');
        return view('admin.home');
    }
}
