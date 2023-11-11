<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\Winner;

class WinnerController extends Controller
{
    public $pool;

    public function __construct()
    {
        $this->pool = Pool::first();
    }

    public function view()
    {
        $winners = Winner::with(['ticket.order', 'ticket'])->get()->all();

        return view('winners.view', [
            'winners' => $winners,
            'pool' => $this->pool
        ]);
    }
}
