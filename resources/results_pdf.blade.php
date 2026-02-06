<!DOCTYPE html>
<html>
<head>
    <title>Exam Results - {{ $student->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Exam Results for {{ $student->name }}</h2>
    <p>Level: {{ $student->level }}</p>
    <p>Category: {{ $student->category }}</p>
    <p>Index Number: {{ $student->index_number }}</p>
    <p>Attempts Left: {{ $student->attempts_left }}</p>

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Marks</th>
                <th>Attempt</th>
                <th>Result</th>
                <th>Resit Needed</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exams as $exam)
            <tr>
                <td>{{ $exam->subject->name }}</td>
                <td>{{ $exam->marks }}</td>
                <td>{{ $exam->attempt_number }}</td>
                <td>{{ $exam->passed ? 'Passed' : 'Failed' }}</td>
                <td>{{ $exam->resit_needed ? 'Yes' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
