@extends('layouts.app')

@section('title', 'Exam Board Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">

    <div class="bg-gradient-to-r from-indigo-700 to-indigo-500 text-white px-8 py-10 shadow">
        <div class="max-w-7xl mx-auto">
            <p class="text-indigo-200 text-sm uppercase tracking-widest font-semibold mb-1">Exam Board Portal</p>
            <h1 class="text-4xl font-bold">Welcome, {{ auth()->user()->name }}</h1>
            <p class="mt-2 text-indigo-100">{{ now()->format('l, F j, Y') }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4">{{ session('error') }}</div>
        @endif

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">

            {{-- Level Breakdown --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Students by Level</h3>
                <canvas id="levelChart"></canvas>
            </div>

            {{-- Category Breakdown --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Students by Category</h3>
                <canvas id="categoryChart"></canvas>
            </div>

            {{-- Pass Rate --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Pass Rate by Subject</h3>
                <canvas id="passRateChart"></canvas>
            </div>
        </div>

        {{-- Subjects Table --}}
        <h2 class="text-xl font-bold text-gray-800 mb-6">Submitted Results</h2>

        @if($subjects->isEmpty())
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-8 text-center">
                <p class="font-semibold">No subjects found.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Subject</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Code</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Instructor</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Status</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($subjects as $subject)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $subject->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $subject->code }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $subject->instructor->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    @if($subject->sent_to_director)
                                        <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded-full">Sent to Director</span>
                                    @elseif($subject->examboard_approved)
                                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">Approved</span>
                                    @elseif($subject->results_submitted)
                                        <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-1 rounded-full">Awaiting Review</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-1 rounded-full">Not Submitted</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($subject->results_submitted && !$subject->sent_to_director)
                                        <a href="{{ route('examboard.review', $subject->id) }}"
                                           class="inline-flex items-center gap-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                            Review
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
    const levelData = @json($levelBreakdown);
    const categoryData = @json($categoryBreakdown);
    const passRateData = @json($passRates);

    new Chart(document.getElementById('levelChart'), {
        type: 'pie',
        data: {
            labels: Object.keys(levelData),
            datasets: [{ data: Object.values(levelData), backgroundColor: ['#6366f1','#a5b4fc','#c7d2fe'] }]
        }
    });

    new Chart(document.getElementById('categoryChart'), {
        type: 'pie',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{ data: Object.values(categoryData), backgroundColor: ['#10b981','#6ee7b7','#a7f3d0'] }]
        }
    });

    new Chart(document.getElementById('passRateChart'), {
        type: 'bar',
        data: {
            labels: passRateData.map(s => s.name),
            datasets: [{
                label: 'Pass Rate %',
                data: passRateData.map(s => s.pass_rate),
                backgroundColor: '#6366f1'
            }]
        },
        options: { scales: { y: { min: 0, max: 100 } } }
    });
</script>
@endsection
