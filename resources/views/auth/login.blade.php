@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto mt-20 p-6 bg-surface rounded-lg shadow-card">
    <h2 class="text-2xl font-bold text-primary mb-6 text-center">Login</h2>
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <input type="email" name="email" placeholder="Email" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
        <input type="password" name="password" placeholder="Password" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
        <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white px-4 py-3 rounded-md">Login</button>
    </form>
</div>
@endsection
