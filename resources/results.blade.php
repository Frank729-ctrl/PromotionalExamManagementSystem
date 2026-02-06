@extends('layouts.app')

@section('title', 'Exam Results')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Exam Results</h1>

    @if($exams->count() > 0)
    <table class="w-full table-auto border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Subject</th>
                <th class="border px-4 py-2">Marks</th>
                <th class="border px-4 py-2">Attempt</th>
                <th class="border px-4 py-2">Result</th>
                <th class="border px-4 py-2">Resit Needed</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exams as $exam)
            <tr>
                <td class="border px-4 py-2">{{ $exam->subject->name }}</td>
                <td class="border px-4 py-2">{{ $exam->marks }}</td>
                <td class="border px-4 py-2">{{ $exam->attempt_number }}</td>
                <td class="border px-4 py-2">
                    {{ $exam->passed ? 'Passed' : 'Failed' }}
                </td>
                <td class="border px-4 py-2">
                    {{ $exam->resit_needed ? 'Yes' : 'No' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('student.results.download') }}" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
        Download Results PDF
    </a>
    @else
        <p>No exam records found.</p>
    @endif
</div>
@endsection
