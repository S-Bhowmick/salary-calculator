<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Salary Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 14px;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtext {
            text-align: center;
            color: #6b7280;
            margin-bottom: 20px;
        }

        .info-box {
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #111827;
            color: white;
        }

        .total-box {
            margin-top: 20px;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f9fafb;
        }
    </style>
</head>
<body>
    <h1>UK Salary Calculator Report</h1>
    <p class="subtext">Generated salary history report</p>

    <div class="info-box">
        <p><strong>User Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Generated At:</strong> {{ now()->format('d M Y, h:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Experience</th>
                <th>Location</th>
                <th>Salary</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($calculations as $calc)
                <tr>
                    <td>{{ $calc->job_title }}</td>
                    <td>{{ $calc->experience }} years</td>
                    <td>{{ $calc->location }}</td>
                    <td>£{{ number_format($calc->calculated_salary) }}</td>
                    <td>{{ $calc->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">No salary records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-box">
        <p><strong>Total Calculations:</strong> {{ $calculations->count() }}</p>
        @if($calculations->count() > 0)
            <p><strong>Latest Salary:</strong> £{{ number_format($calculations->first()->calculated_salary) }}</p>
        @else
            <p><strong>Latest Salary:</strong> £0</p>
        @endif
    </div>
</body>
</html>