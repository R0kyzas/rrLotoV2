@extends('layouts.layout')

@section('title', 'Pagrindinis Puslapis')

@section('content')
<div class="container">
    <div class="card card-ticket">
        <div class="card-header primary-bg-color text-white">
            Your orders
        </div>
        <div class="card-body">
        @if($orders->isNotEmpty())
            @foreach($orders as $order)
                <div class="dropdown mb-4">
                    <button class="btn second-bg-color second-text-color btn-secondary dropdown-toggle d-flex w-full justify-content-between align-items-center" type="button" id="dropdownMenuButton-{{ $order->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div>Order nr: <span class="font-weight-bold">{{ $order->order_nr }}</span></div> 
                    </button>
                    <div class="dropdown-menu w-full" aria-labelledby="dropdownMenuButton-{{ $order->id }}">
                        <div class="dropdown-item">
                            Order status:
                            @if ($order->active === 0)
                                <span class="text-warning">Waiting for activation</span>
                            @elseif ($order->active === 1)
                                <span class="text-success">Activeded</span>
                            @elseif ($order->active === 2)
                                <span class="text-danger">Canceled</span>
                            @endif
                        </div>
                        <div class="dropdown-item">
                            Ticket numbers:
                            @if($order->tickets->isNotEmpty())
                                @foreach($order->tickets as $ticket)
                                    #{{ $ticket->ticket_number }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @else
                                <p>No tickets for this order.</p>
                            @endif   
                        </div>
                    </div>
                </div>
            @endforeach
            @else
            <p>You dont have orders right now.</p>
        @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        @foreach($orders as $order)
            $('#dropdownMenuButton-{{ $order->id }}').dropdown();
        @endforeach
    });
</script>
@endsection
