<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function view(Request $request)
    {
        $token = json_decode($request->cookie('userToken'), true);

        $orders = Order::with('tickets')
        ->whereHas('tickets', function($q) use($token){
            $q->where('token', '=', $token);
        })->get();

        return view('profile', [
            'orders' => $orders,
        ]);
    }
}
