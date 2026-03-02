@extends('layouts.app')

@section('title', 'Edit Exam Result')

@section('content')
<div class="min-h-screen bg-gray-50">

    <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white px-8 py-10 shadow">
        <div class="max-w-2xl mx-auto">
            <a href="{{ route('instructor.subject.students', $exam->subject_id) }}" class="text-blue-200 hover:text-white text-sm flex items-center gap-1 mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Students
            </a>
            <h1 class="text-4xl font-bold">Edit Exam Result</h1>
            <p class="mt-2 text-blue-100">{{ $exam->student->user->name }} &bull; {{ $exam->subject->name }}</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-6 py-10">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('instructor.exam.update', $exam->id) }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Student</label>
                    <input type="text" value="{{ $exam->student->user->name }}" disabled
                           class="w-full border border-gray-200 rounded-lg px-4 py-2 bg-gray-50 text-gray-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Subject</label>
                    <input type="text" value="{{ $exam->subject->name }}" disabled
                           class="w-full border border-gray-200 rounded-lg px-4 py-2 bg-gray-50 text-gray-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Marks (0–500)</label>
                    <input type="number" name="marks" value="{{ old('marks', $exam->marks) }}" min="0" max="500" placeholder="Leave empty if absent"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('marks')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('instructor.subject.students', $exam->subject_id) }}"
                       class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                        Save Result
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
