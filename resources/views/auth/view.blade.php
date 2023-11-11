@extends('layouts.layout')

@section('title', 'Pagrindinis Puslapis')

@section('content')
<div class="container mb-0.5">
        <div class="card card-ticket">
            <div class="card-header primary-bg-color text-white d-flex justify-content-between align-items-center">
                <div>
                    Login
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('auth.login') }}">
                    @csrf

                    <label for="email">Name:</label>
                    <input type="text" class="form-control" name="email" id="email" required>

                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" required>

                    <button type="submit" class="btn btn-primary mt-2">Login</button>
                </form>
            </div>
        </div>
</div>
<!-- <div class="max-w-md mx-auto bg-gray-100 shadow-lg rounded-md overflow-hidden card-ticket mt-4">
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
</div> -->
@endsection