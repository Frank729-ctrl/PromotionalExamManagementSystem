@extends('layouts.app')

@section('title', 'Students - ' . $subject->name)

@section('content')
<div class="min-h-screen bg-gray-50">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white px-8 py-10 shadow">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('instructor.dashboard') }}" class="text-blue-200 hover:text-white text-sm flex items-center gap-1 mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
            <p class="text-blue-200 text-sm uppercase tracking-widest font-semibold mb-1">Subject</p>
            <h1 class="text-4xl font-bold">{{ $subject->name }}</h1>
            <p class="mt-2 text-blue-100">Code: {{ $subject->code ?? 'N/A' }} &bull; Group: {{ $subject->group ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- Flash Messages --}}
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

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Enrolled Students</h2>
            <span class="text-sm text-gray-400">{{ $students->count() }} student(s)</span>
        </div>

        @if($students->isEmpty())
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-8 text-center">
                <p class="font-semibold text-lg">No students found</p>
                <p class="text-sm text-yellow-600 mt-1">No students have taken exams for this subject yet.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">#</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Student Name</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Index Number</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Level</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Attempts Left</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Exam Status</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($students as $index => $student)
                            @php
                                $exam = $student->exams->where('subject_id', $subject->id)->first();
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $student->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $student->index_number }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded-full">
                                        Level {{ $student->level }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $student->attempts_left }}</td>
                                <td class="px-6 py-4">
                                    @if($exam && $exam->submitted_for_approval)
                                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">Submitted</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded-full">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($exam && !$exam->submitted_for_approval)
                                        <a href="{{ route('instructor.exam.edit', $exam->id) }}"
                                           class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                            Edit Result
                                        </a>
                                    @elseif($exam && $exam->submitted_for_approval)
                                        <span class="text-gray-400 text-xs">Locked</span>
                                    @else
                                        <span class="text-gray-400 text-xs">No exam</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Submit Results --}}
            <div class="mt-8 flex justify-end">
                @if(!$subject->results_submitted)
                    <form method="POST" action="{{ route('instructor.subject.submit', $subject->id) }}"
                          onsubmit="return confirm('Are you sure? You will not be able to edit results after submitting.')">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Submit Final Results
                        </button>
                    </form>
                @else
                    <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl px-5 py-4">
                        Results have been submitted and are awaiting approval.
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection