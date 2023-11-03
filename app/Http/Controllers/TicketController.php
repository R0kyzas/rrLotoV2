<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketPrice;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class TicketController extends Controller
{
    public function create(Request $request): View
    {
        $ticketPrice = TicketPrice::first();

        $userData = json_decode($request->cookie('userData'), true);

        return view('home', [
            'ticketPrice' => $ticketPrice->price,
            'userData' => $userData,
        ]);
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
            try {
                $ticketPrice = TicketPrice::first();
    
                $discountCode = $request->input('discount');
                $isValidDiscount = null;
                if($discountCode){
                    $isValidDiscount = Discount::where('code', $discountCode)->first();
                }
    
                $finalAmount = $ticketPrice->price * $request->ticket_quantity;
                if ($isValidDiscount && $ticketPrice->price) {
                    $finalAmount *= (1 - $isValidDiscount->percentage / 100);
                }
    
                $order = Order::create([
                    $request->validated(),
                    'ticket_quantity' => $request->ticket_quantity,
                    'order_nr' => $this->getRandomOrderNumber(),
                    'final_price' => $finalAmount * 100,
                    'payment_method' => $request->payment_method,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'token' => json_decode($request->cookie('userToken'), true),
                ]);

                for ($i=0; $i < $request->ticket_quantity; $i++) {
                    Ticket::create([
                        'order_id' => $order->id,
                        'ticket_number' => $this->generateUniqueTicketNumber(),
                    ]);  
                }

                $cookieData = [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'payment_method' => $request->payment_method,
                ];
                $cookie = Cookie::make('userData', json_encode($cookieData), Carbon::now()->addYear()->timestamp);
    
                return redirect()
                    ->route('profile')
                    ->with('success', 'Duomenys sėkmingai įrašyti!')
                    ->cookie($cookie)
                ;
            } catch (\Throwable $th) {
                return back()->withInput()->withErrors(['error' => $th]);
            }
    }

    public function getRandomOrderNumber()
    {
        do {
            $orderNumber = Str::random(6);
        } while (Order::where("order_nr", "=", $orderNumber)->first());
        
        return $orderNumber;
    }


    public function generateUniqueTicketNumber()
    {
        do {
            $ticketRandomNumber = random_int(1, 9999);
        } while (Ticket::where("ticket_number", "=", $ticketRandomNumber)->first());
  
        return $ticketRandomNumber;
    }

    public function applyDiscount(Request $request)
    {
        $discountCode = $request->input('discount');
        $validDiscount = Discount::where('code', $discountCode)->get();

        return response()->json([
            'status' => 200,
            'validDiscount' => $validDiscount,
        ]);
    }
}
