<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pool;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public $pool;

    public function __construct()
    {
        $this->pool = Pool::first();
    }

    public function view(Request $request)
    {
        $token = json_decode($request->cookie('userToken'), true);

        $orders = Order::with('tickets')
        ->whereHas('tickets', function($q) use($token){
            $q->where('token', '=', $token);
        })->get();

        return view('profile.view', [
            'orders' => $orders,
            'pool' => $this->pool
        ]);
    }

    public function viewTickets($orderId)
    {

        $order = Order::with('tickets')->find($orderId);

        if ($order) {
            $orderNumber = $order->order_nr;
            $ticketNumbers = $order->tickets->pluck('ticket_number');
        
            return view('profile.tickets', [
                'orderNumber' => $orderNumber,
                'ticketNumbers' => $ticketNumbers,
                'pool' => $this->pool,
            ]);
        } else {

            return view('profile.tickets', [
                'pool' => $this->pool
            ])->with('error', 'Something wrong...');
        }
    }
}
