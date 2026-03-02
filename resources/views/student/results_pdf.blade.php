<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Results - {{ $student->index_number }}</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; color: #333; font-size: 13px; }
        h1 { font-size: 22px; border-bottom: 2px solid #4F46E5; padding-bottom: 8px; margin-bottom: 16px; }
        .info p { margin: 4px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #E5E7EB; padding: 8px 12px; text-align: left; }
        th { background-color: #F3F4F6; font-weight: 600; }
        .pass { color: #166534; font-weight: bold; }
        .fail { color: #991B1B; font-weight: bold; }
        .absent { color: #6B7280; }
        .notice { margin-top: 20px; padding: 10px; border-radius: 4px; font-size: 12px; }
        .notice.full { background: #FEE2E2; color: #991B1B; }
        .notice.single { background: #FEF3C7; color: #78350F; }
        .footer { margin-top: 30px; font-size: 11px; color: #9CA3AF; }
    </style>
</head>
<body>
    <h1>Promotional Exam Results</h1>

    <div class="info">
        <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Index Number:</strong> {{ $student->index_number }}</p>
        <p><strong>Level:</strong> {{ $student->level }}</p>
        <p><strong>Category:</strong> {{ $student->category }}</p>
        <p><strong>Attempts Left:</strong> {{ $student->attempts_left }}</p>
    </div>

    @if($resitType === 'full')
        <div class="notice full">⚠️ Full Resit Required — You failed 2 or more subjects and must resit the entire examination.</div>
    @elseif($resitType === 'single')
        <div class="notice single">⚠️ Single Paper Resit — You must resit: {{ $failedExams->first()->subject->name }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Attempt</th>
                <th>Marks</th>
                <th>Status</th>
                <th>Resit Required</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exams as $exam)
            <tr>
                <td>{{ $exam->subject->name }}</td>
                <td>{{ $exam->attempt_number }}</td>
                <td>{{ is_null($exam->marks) ? '—' : $exam->marks }}</td>
                <td>
                    @if($exam->status === 'Pass')
                        <span class="pass">Pass</span>
                    @elseif($exam->status === 'Fail')
                        <span class="fail">Fail</span>
                    @else
                        <span class="absent">Absent</span>
                    @endif
                </td>
                <td>{{ $exam->resit_needed ? 'Yes' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="footer">Generated on {{ now()->format('d M Y, H:i') }}</p>
</body>
</html>
