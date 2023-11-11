@extends('layouts.layout')

@section('title', 'Pagrindinis Puslapis')

@section('content')
@include('pool-progress', ['pool' => $pool])
<div class="container">
    <div class="card card-ticket">
        <div class="card-header primary-bg-color text-white">
            Order number: <span class="font-weight-bold">{{ $orderNumber }}</span>
        </div>
        <div class="card-body">
            <div>
                Ticket numbers:
            </div>
            @foreach ($ticketNumbers as $ticketNumber)
                <span class="font-weight-bold">#{{ $ticketNumber }}@if (!$loop->last), @endif</span>
            @endforeach
            <div class="mt-2">
                <a href="{{ route('profile.view') }}" class="btn primary-bg-color text-white">Back</a>
            </div>
        </div>
    </div>
</div>

@endsection