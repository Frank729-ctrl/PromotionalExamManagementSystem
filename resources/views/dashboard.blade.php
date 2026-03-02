@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->name }}</h1>
</div>
@endsection
