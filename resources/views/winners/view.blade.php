@extends('layouts.layout')

@section('title', 'Pagrindinis Puslapis')

@section('content')
    @include('pool-progress', ['pool' => $pool])

    <div class="container">
        @if($winners)
            @foreach ($winners as $winner)
            <div class="card card-ticket">
                <div class="card-header primary-bg-color text-white">
                            Winner {{ $winner->ticket->order->first_name }} {{ $winner->ticket->order->last_name }}
                </div>
                <div class="card-body">
                    Winner ticket number - {{ $winner->ticket->ticket_number }}
                </div>
                <!-- <div class="card-body">
                            Winner ticket number - {{ $winner->ticket->ticket_number }}
                        <div> -->
            </div>
            @endforeach
    
        @else
            <div class="card card-ticket">
                        <div class="card-header primary-bg-color text-white">
                            No winners selected
                        </div>
                        <div class="card-body">
                            No winner has been chosen yet
                        <div>
                    </div>
                    
         @endif
    </div>
@endsection