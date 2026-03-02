@extends('layouts.app')

@section('title', 'Review - ' . $subject->name)

@section('content')
<div class="min-h-screen bg-gray-50">

    <div class="bg-gradient-to-r from-indigo-700 to-indigo-500 text-white px-8 py-10 shadow">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('examboard.dashboard') }}" class="text-indigo-200 hover:text-white text-sm flex items-center gap-1 mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
            <h1 class="text-4xl font-bold">{{ $subject->name }}</h1>
            <p class="mt-2 text-indigo-100">Code: {{ $subject->code }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4">{{ session('error') }}</div>
        @endif

        {{-- Exam Results Table --}}
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
                            <td class="px-6 py-4 text-gray-800 font-semibold">{{ $exam->marks }}</td>
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

        {{-- Approve / Disapprove --}}
        @if(!$subject->examboard_approved && !$subject->sent_to_director)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Approve --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 text-lg">✅ Approve Results</h3>
                    <form method="POST" action="{{ route('examboard.approve', $subject->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Remarks (optional)</label>
                            <textarea name="remarks" rows="3"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Add any remarks..."></textarea>
                        </div>
                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Approve & Forward to Director
                        </button>
                    </form>
                </div>

                {{-- Disapprove --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 text-lg">❌ Disapprove Results</h3>
                    <form method="POST" action="{{ route('examboard.disapprove', $subject->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reason <span class="text-red-500">*</span></label>
                            <textarea name="remarks" rows="3" required
                                class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                placeholder="Explain why results are being returned..."></textarea>
                        </div>
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Disapprove & Return to Instructor
                        </button>
                    </form>
                </div>
            </div>

        @elseif($subject->examboard_approved && !$subject->sent_to_director)
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 flex items-center justify-between">
                <div>
                    <p class="font-bold text-green-800">Results Approved</p>
                    <p class="text-sm text-green-600 mt-1">You can now send these results to the Director General for publication.</p>
                </div>
                <form method="POST" action="{{ route('examboard.send_to_director', $subject->id) }}">
                    @csrf
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                        Send to Director General
                    </button>
                </form>
            </div>

        @elseif($subject->sent_to_director)
            <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-6">
                <p class="font-bold">Results sent to Director General.</p>
                <p class="text-sm mt-1">Awaiting publication.</p>
            </div>
        @endif

    </div>
</div>
@endsection
