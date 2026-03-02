@extends('layouts.app')

@section('title', 'Review - ' . $subject->name)

@section('content')
<div class="min-h-screen bg-gray-50">

    <div class="bg-white border-b border-gray-200 px-8 py-10 shadow">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('director.dashboard') }}" class="text-emerald-600 hover:text-emerald-800 text-sm flex items-center gap-1 mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
            <h1 class="text-4xl font-bold text-gray-800">{{ $subject->name }}</h1>
            <p class="mt-2 text-gray-500">Code: {{ $subject->code }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4">{{ session('success') }}</div>
        @endif

        {{-- Results Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600">#</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600">Student</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600">Index No.</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600">Marks</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($exams as $index => $exam)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $exam->student->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $exam->student->index_number }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $exam->marks }}</td>
                            <td class="px-6 py-4">
                                @if($exam->status === 'Pass')
                                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">Pass</span>
                                @elseif($exam->status === 'Fail')
                                    <span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded-full">Fail</span>
                                @else
                                    <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-1 rounded-full">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Publish Form --}}
        @if(!$subject->published)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-bold text-gray-800 text-lg mb-6">Publish Results to Student Portal</h3>
                <form method="POST" action="{{ route('director.publish', $subject->id) }}">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Director General Remarks <span class="text-gray-400">(optional)</span></label>
                        <textarea name="director_remarks" rows="4"
                            class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Add remarks about this examination, overall performance, etc..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                                onclick="return confirm('Publish results to student portal? This cannot be undone.')"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-8 py-3 rounded-lg transition">
                            Publish Results
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-6">
                <p class="font-bold text-lg">✅ Results Published</p>
                @if($subject->director_remarks)
                    <p class="mt-2 text-sm"><span class="font-semibold">Remarks:</span> {{ $subject->director_remarks }}</p>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
