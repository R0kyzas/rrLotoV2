@extends('layouts.layout')

@section('title', 'Pagrindinis Puslapis')

@section('content')
<div class="max-w-md mx-auto bg-gray-100 shadow-lg rounded-md overflow-hidden card-ticket mt-4">
    <div class="primary-bg-color text-white p-4 flex justify-between">
        <div class="font-bold text-lg">Login</div>
        <div class="text-lg"><i class="fab fa-cc-visa"></i></div>
    </div>
    <div class="p-6">
        <form method="POST" action="{{ route('auth.login') }}">
            @csrf

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</div>
@endsection