@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->name }}</h1>

    <p>Level: {{ $student->level }}</p>
    <p>Category: {{ $student->category }}</p>
    <p>Index Number: {{ $student->index_number }}</p>
    <p>Attempts Left: {{ $student->attempts_left }}</p>

    <a href="{{ route('student.results') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        View Exam Results
    </a>
</div>
@endsection
