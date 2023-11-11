<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Order;
use App\Models\Pool;
use App\Models\Ticket;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public $pool;

    public function __construct()
    {
        $this->pool = Pool::first();
    }

    public function view(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');
        $payment_method = $request->input('payment_method');

        $orders = Order::with('tickets')
        ->where(function($queryBuilder) use ($query) {
            $queryBuilder->where('first_name', 'like', '%' . $query . '%')
                ->orWhere('last_name', 'like', '%' . $query . '%')
                ->orWhere('order_nr', 'like', '%' . $query . '%');
        });

        if ($status !== null) {
            $orders->where('active', '=', intval($status));
        }

        if ($payment_method !== null) {
            $orders->where('payment_method', '=', intval($payment_method));
        }

        $orders = $orders->get()->all();

        return view('admin.home', [
            'orders' => $orders,
            'query' => $query,
            'status' => $status,
            'payment_method' => $payment_method,
            'pool' => $this->pool
        ]);
    }

    public function viewDiscount()
    {
        $discounts = Discount::all();

        return view('admin.discount', [
            'discounts' => $discounts,
            'pool' => $this->pool
        ]);
    }

    public function createDiscount(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:discounts,code|min:3',
            'percentage' => 'required|numeric|min:5',
        ]);

        if($validated)
        {
           $discount = Discount::create([
               'code' => $request->code,
               'percentage' => $request->percentage,
           ]);
        }

        if($discount)
        {
            session()->flash('success', 'Discount code generated successfully !');

            return redirect()
                ->route('admin.home')
            ;
        }else{
            session()->flash('error', 'Something wrong...');

            return view('admin.discount');
        }
    }

    public function deleteDiscount($id)
    {
        try {
            $discount = Discount::findOrFail($id);
            $discount->delete();

            session()->flash('success', 'Discount code deleted successfully !');
        } catch (\Throwable $th) {
            session()->flash('error', 'Something wrong...');
        }

        return redirect()
                ->route('admin.discount')
            ;
    }

    public function activateOrder($id)
    {
        $order = Order::find($id);

        if($order)
        {
            $order->active = 1;
            $order->save();
            
            return redirect()
                ->route('admin.home')
                ->with('succes', 'Order activated successfully !')
            ;
        }else{
            return redirect()
                ->route('admin.home')
                ->with('error', 'Something wrong...')
            ; 
        }
    }

    public function cancelOrder($id)
    {
        $order = Order::find($id);

        if($order)
        {
            $order->active = 2;
            $order->save();
            
            return redirect()
                ->route('admin.home')
                ->with('succes', 'Order canceled successfully !')
            ;
        }else{
            return redirect()
                ->route('admin.home')
                ->with('error', 'Something wrong...')
            ;
        }

    }

    public function getWinner(){
        try {
            $winner = DB::table('tickets')
            ->select('tickets.*')
            ->leftJoin('winners','tickets.id','=','winners.ticket_id')
            ->whereNull('winners.id')
            ->rightJoin('orders', 'orders.id', '=', 'tickets.order_id')
            ->where('orders.active', '=', 1)
            ->orderByRaw('RAND()')
            ->limit(1)
            ->first();
    
            if ($winner) {
                Winner::create(['ticket_id' => $winner->id]);
    
                return redirect()->route('admin.home')->with('success', 'The winner of the ticket has been chosen!');
            } else {
                return redirect()->route('admin.home')->with('error', 'There are no tickets that can be assigned a win...');
            }
        } catch (\Throwable $th) {
            return redirect()->route('admin.home')->with('error', 'An error occurred while selecting the winner.');
        }
    }

    public function generateCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        do {
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $randomIndex = mt_rand(0, strlen($characters) - 1);
                $code .= $characters[$randomIndex];
            }
            $existingCode = Discount::where('code', $code)->first();
        } while ($existingCode || strlen($code) < 3);

        return response()->json(['code' => $code]);
    }
}
