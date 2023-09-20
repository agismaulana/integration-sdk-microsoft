@extends('layout.main')

@push('css')
    <style>
        .form {
            width: 50%;
            display: flex;
            flex-direction: column;
            gap: 6;
        }
    </style>
@endpush

@section('main')
    <h1>Register</h1>
    <form action="{{ route('web.auth.register.send') }}" method="POST">
        @csrf
        <div class="form">
            <input type="text" name="name" placeholder="Full Name">
            <input type="text" name="email" placeholder="email">
            <input type="password" name="password" placeholder="password">
            <button type="submit">Register</button>
        </div>
    </form>
@endsection
