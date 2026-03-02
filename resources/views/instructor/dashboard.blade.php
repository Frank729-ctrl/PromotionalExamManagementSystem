@extends('layouts.app')

@section('title', 'Instructor Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">

    {{-- Header Banner --}}
    <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white px-8 py-10 shadow">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div>
                <p class="text-blue-200 text-sm uppercase tracking-widest font-semibold mb-1">Instructor Portal</p>
                <h1 class="text-4xl font-bold">Welcome back, {{ auth()->user()->name }}</h1>
                <p class="mt-2 text-blue-100">{{ now()->format('l, F j, Y') }}</p>
            </div>
            <div class="hidden md:flex items-center justify-center bg-white/20 rounded-full w-20 h-20 text-4xl font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- Stats Bar --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center gap-4 border border-gray-100">
                <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Subjects</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $subjects->count() }}</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center gap-4 border border-gray-100">
                <div class="bg-green-100 text-green-600 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6 5.87H9m6 0a4 4 0 10-6 0"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Assigned Students</p>
                    <p class="text-2xl font-bold text-gray-800">—</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center gap-4 border border-gray-100">
                <div class="bg-purple-100 text-purple-600 rounded-full p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Results Pending</p>
                    <p class="text-2xl font-bold text-gray-800">—</p>
                </div>
            </div>
        </div>

        {{-- Subjects Section --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Your Subjects</h2>
            <span class="text-sm text-gray-400">{{ $subjects->count() }} subject(s) assigned</span>
        </div>

        @if($subjects->isEmpty())
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-8 text-center">
                <svg class="w-12 h-12 mx-auto mb-3 text-yellow-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
                </svg>
                <p class="font-semibold text-lg">No subjects assigned yet</p>
                <p class="text-sm text-yellow-600 mt-1">Please contact the administrator to get subjects assigned to you.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($subjects as $subject)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
                        {{-- Card Header --}}
                        <div class="bg-gradient-to-r from-blue-600 to-blue-400 px-5 py-4">
                            <h3 class="text-white font-bold text-lg leading-tight">{{ $subject->name }}</h3>
                            <span class="inline-block mt-1 bg-white/20 text-white text-xs px-2 py-0.5 rounded-full">
                                {{ $subject->code }}
                            </span>
                        </div>
                        {{-- Card Body --}}
                        <div class="px-5 py-4">
                            <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Category: <span class="text-gray-700 font-medium">{{ $subject->category }}</span>
                            </div>
                        </div>
                        {{-- Card Footer --}}
                        <div class="px-5 pb-5">
                            <a href="{{ route('instructor.subject.students', $subject->id) }}"
                               class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6 5.87H9m6 0a4 4 0 10-6 0"/>
                                </svg>
                                View Students
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection