@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card" style="width: 400px;">
        <div class="card-body">
            <p style="text-align: center">Welcome To Inventory Management Website Please Login First</p>
            <center>
                <img src="{{asset('assets/logo/logo.png')}}" alt="Logo">
         </center>
            <h3 class="card-title text-center">Login</h3>
            <form method="POST" action="{{ route('process.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                @if (Route::has('register'))
                    <div class="mt-3 text-center">
                        <a href="{{ route('register') }}">Don't have an account? Register</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
