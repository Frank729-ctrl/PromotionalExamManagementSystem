@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">

    <div class="bg-white border-b border-gray-200 px-8 py-10 shadow">
        <div class="max-w-7xl mx-auto">
            <p class="text-blue-600 text-sm uppercase tracking-widest font-semibold mb-1">Student Portal</p>
            <h1 class="text-4xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}</h1>
            <p class="mt-2 text-gray-500">{{ now()->format('l, F j, Y') }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-sm text-gray-500 mb-1">Index Number</p>
                <p class="text-xl font-bold text-gray-800">{{ $student->index_number }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-sm text-gray-500 mb-1">Level</p>
                <p class="text-xl font-bold text-blue-600">{{ $student->level }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-sm text-gray-500 mb-1">Category</p>
                <p class="text-xl font-bold text-purple-600">{{ $student->category }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-sm text-gray-500 mb-1">Attempts Left</p>
                <p class="text-xl font-bold {{ $student->attempts_left > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $student->attempts_left }}
                </p>
            </div>
        </div>

        {{-- Resit Notice --}}
        @if($resitType === 'full')
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4">
                <p class="font-bold">⚠️ Full Resit Required</p>
                <p class="text-sm mt-1">You failed 2 or more subjects. You must resit the entire examination. Attempts remaining: <strong>{{ $student->attempts_left }}</strong></p>
            </div>
        @elseif($resitType === 'single')
            <div class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl px-5 py-4">
                <p class="font-bold">⚠️ Single Paper Resit Required</p>
                <p class="text-sm mt-1">You failed 1 subject. You only need to resit: <strong>{{ $failedExams->first()->subject->name }}</strong>. Attempts remaining: <strong>{{ $student->attempts_left }}</strong></p>
            </div>
        @endif

        {{-- Results Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-800">Exam Results</h2>
                @if($exams->isNotEmpty())
                    <a href="{{ route('student.results.download') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download PDF
                    </a>
                @endif
            </div>

            @if($exams->isEmpty())
                <div class="px-6 py-10 text-center text-gray-400">
                    <p class="font-semibold">No published results yet.</p>
                    <p class="text-sm mt-1">Results will appear here once published by the Director General.</p>
                </div>
            @else
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Subject</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Attempt</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Marks</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Status</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Resit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($exams as $exam)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $exam->subject->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $exam->attempt_number }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ is_null($exam->marks) ? '—' : $exam->marks }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($exam->status === 'Pass')
                                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">Pass</span>
                                    @elseif($exam->status === 'Fail')
                                        <span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded-full">Fail</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-1 rounded-full">Absent</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($exam->resit_needed)
                                        <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-1 rounded-full">Required</span>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
