@extends('layouts.app')

@section('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@endsection

@section('content')
<div class="login row">
    <div class="section-left col-md-7">
        <div class="section-1">
            <div class="sign-in-form">
                <div class="heading">
                    Sign In
                </div>
                <form class="sign-in-form-container" action="{{route('login')}}" method="POST">
                    @csrf
                    <div class="form-control">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Your email address" required>
                        @error('email')
                            <p><strong class="text-danger">{{$message}}</strong></p>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Create your password" required>
                        @error('password')
                            <p><strong class="text-danger">{{$message}}</strong></p>
                        @enderror
                    </div>

                    <div class="button-container">
                        <button type="submit" id="nextBtn">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="section-2">
            <div class="text-1">
                Create an account
            </div>
            <div class="text-2">
                <a href="{{route('register')}}">Sign Up</a>
            </div>
        </div>
    </div>
    <div class="section-right col-md-5">
        <div class="text-section">
            <div class="text-1">Sign up to</div>
            <div class="text-2">Create Your Donation Account</div>
            <div class="items">
                <div class="item">
                    <div class="icon"></div>
                    <div class="text">Lorem ipsum dolor sit amet</div>
                </div>

                <div class="item">
                    <div class="icon"></div>
                    <div class="text">Lorem ipsum dolor sit amet</div>
                </div>

                <div class="item">
                    <div class="icon"></div>
                    <div class="text">Lorem ipsum dolor sit amet</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection