<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function view(Request $request)
    {
        $userData = json_decode($request->cookie('userData'), true);
        return view('profile');
    }
}
