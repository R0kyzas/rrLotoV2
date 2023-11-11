<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use Illuminate\Http\Request;

class PoolController extends Controller
{
    public $pool;

    public function __construct()
    {
        $this->pool = Pool::first();
    }

    public function view()
    {

        return view('admin.pool.view', [
            'pool' => $this->pool
        ]);
    }
    
    public function store(Request $request)
    {
        $existingPool = Pool::count();

        if ($existingPool > 0) {
            return redirect()->route('admin.home')->with('error', 'A pool already exists. Only one can be created.');
        }

        Pool::create([
            'target_amount' => $request->target_amount * 100,
        ]);

        return redirect()->route('admin.pool.view')->with('success', 'Pool created successfully');
    }

    public function changeStatus($id)
    {
        $pool = Pool::find($id);

        if($pool)
        {
            if($pool->active === 1)
            {
                $pool->active = 0;
            }else{
                $pool->active = 1;
            }
            $pool->save();

            return redirect()->route('admin.pool.view')->with('success', 'Status successfully updated !');
        }else{
            return redirect()->route('admin.pool.view')->with('error', 'Something wrong...');
        }
    }

    public function deletePool($id)
    {
        $pool = Pool::find($id);

        if($pool)
        {
            $pool->delete();

            return redirect()->route('admin.pool.view')->with('success', 'Pool successfully deleted !');
        }else{
            return redirect()->route('admin.pool.view')->with('error', 'Something wrong...');
        }
    }
}
