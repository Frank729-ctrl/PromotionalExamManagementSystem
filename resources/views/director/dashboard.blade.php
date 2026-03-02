@extends('layouts.app')

@section('title', 'Director General Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">

    <div class="bg-white border-b border-gray-200 px-8 py-10 shadow">
        <div class="max-w-7xl mx-auto">
            <p class="text-emerald-600 text-sm uppercase tracking-widest font-semibold mb-1">Director General Portal</p>
            <h1 class="text-4xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}</h1>
            <p class="mt-2 text-gray-500">{{ now()->format('l, F j, Y') }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4">{{ session('success') }}</div>
        @endif

        {{-- Stats Bar --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-gray-800">{{ $totalStudents }}</p>
                <p class="text-sm text-gray-500 mt-1">Total Students</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-green-600">{{ $totalPassed }}</p>
                <p class="text-sm text-gray-500 mt-1">Passed</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-red-600">{{ $totalFailed }}</p>
                <p class="text-sm text-gray-500 mt-1">Failed</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-yellow-600">{{ $totalPending }}</p>
                <p class="text-sm text-gray-500 mt-1">Pending</p>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Pass vs Fail</h3>
                <canvas id="passFailChart"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Students by Level</h3>
                <canvas id="levelChart"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Pass Rate by Subject</h3>
                <canvas id="passRateChart"></canvas>
            </div>
        </div>

        {{-- Subjects Table --}}
        <h2 class="text-xl font-bold text-gray-800 mb-6">Results Awaiting Publication</h2>

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
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Pass Rate</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Status</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($subjects as $subject)
                            @php
                                $total = $subject->exams->count();
                                $passed = $subject->exams->where('status', 'Pass')->count();
                                $rate = $total > 0 ? round(($passed / $total) * 100) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $subject->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $subject->code }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $subject->instructor->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold {{ $rate >= 50 ? 'text-green-600' : 'text-red-600' }}">{{ $rate }}%</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($subject->published)
                                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">Published</span>
                                    @elseif($subject->sent_to_director)
                                        <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-1 rounded-full">Awaiting Publication</span>
                                    @elseif($subject->examboard_approved)
                                        <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded-full">Exam Board Approved</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-1 rounded-full">Not Ready</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($subject->sent_to_director && !$subject->published)
                                        <a href="{{ route('director.review', $subject->id) }}"
                                           class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                            Review & Publish
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
    const subjectStats = @json($subjectStats);
    const levelData = @json($levelBreakdown);

    new Chart(document.getElementById('passFailChart'), {
        type: 'doughnut',
        data: {
            labels: ['Passed', 'Failed', 'Pending'],
            datasets: [{
                data: [{{ $totalPassed }}, {{ $totalFailed }}, {{ $totalPending }}],
                backgroundColor: ['#10b981', '#ef4444', '#f59e0b']
            }]
        }
    });

    new Chart(document.getElementById('levelChart'), {
        type: 'pie',
        data: {
            labels: Object.keys(levelData),
            datasets: [{ data: Object.values(levelData), backgroundColor: ['#6366f1','#a5b4fc','#c7d2fe'] }]
        }
    });

    new Chart(document.getElementById('passRateChart'), {
        type: 'bar',
        data: {
            labels: subjectStats.map(s => s.name),
            datasets: [{
                label: 'Pass Rate %',
                data: subjectStats.map(s => s.pass_rate),
                backgroundColor: '#10b981'
            }]
        },
        options: { scales: { y: { min: 0, max: 100 } } }
    });
</script>
@endsection
