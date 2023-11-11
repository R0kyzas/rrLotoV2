@extends('layouts.layout')

@section('title', 'Pagrindinis Puslapis')

@section('content')
@include('pool-progress', ['pool' => $pool])
  <div class="container mb-0.5">
    <div class="card card-ticket">
      <div class="card-header primary-bg-color text-white">
        Your orders
      </div>
      <div class="card-body">
      @if($orders->isNotEmpty())
          @foreach($orders as $order)
        <div class="dropdown mb-4">
          <button
            class="btn btn-primary dropdown-toggle second-bg-color second-text-color d-flex w-full justify-content-between align-items-center"
            type="button"
            id="dropdownMenuButton"
            data-mdb-toggle="dropdown"
            aria-expanded="false"
          >
            <div>Order number: <span class="font-weight-bold">{{ $order->order_nr }}</span></div> 
          </button>
          <ul class="dropdown-menu w-full" aria-labelledby="dropdownMenuButton">
            <li>
              <div class="dropdown-item">
                    Order status:
                    @if ($order->active === 0)
                      <span class="text-warning">Waiting for activation</span>
                    @elseif ($order->active === 1)
                      <span class="text-success">Activated</span>
                    @elseif ($order->active === 2)
                      <span class="text-danger">Canceled</span>
                    @endif
                  </div>
            </li>
            <li>
            <div class="dropdown-item">
                    Total tickets: 
                    @if($order->tickets->isNotEmpty())
                      <span class="font-weight-bold ml-1">{{ $order->tickets->count() }}</span>
                    @else
                      <p>No tickets for this order.</p>
                    @endif   
                  </div>
            </li>
            <li>
              <div class="dropdown-body-button">
                    <a 
                      class="btn btn-primary primary-bg-color"
                      data-toggle="collapse" 
                      href="{{ route('profile.tickets', $order->id ) }}"
                      role="button" 
                      aria-expanded="false" 
                      aria-controls="collapseExample"
                    >
                      See all tickets
                    </a>
                  </div>
            </li>
          </ul>
        </div>
        @endforeach
        @else
          <p>You dont have orders right now.</p>
        @endif
      </div>
    </div>
  </div>
@endsection