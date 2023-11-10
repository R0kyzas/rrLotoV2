<?php

namespace App\Http\Controllers;

use App\Enums\PaymentType;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketPrice;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function create(): View
    {
        $ticketPrice = TicketPrice::first();

        return view('home', [
            'ticketPrice' => $ticketPrice->price,
        ]);
    }

    public function store(StoreOrderRequest $request, PaymentController $paymentController)
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
    
                if(intval($request->payment_method) === PaymentType::Paysera)
                {
                    $paymentController->initiatePayment($order->id, $order->final_price);
                }else{
                    return redirect()
                        ->route('profile')
                        ->with('success', 'Duomenys sėkmingai įrašyti!')
                    ;
                }

            } catch (\Throwable $th) {
                return back()->withInput()->withErrors(['error' => 'error']);
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
