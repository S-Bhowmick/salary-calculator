<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printable Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111827;
            margin: 30px;
        }
        h1, h2 {
            margin-bottom: 10px;
        }
        .meta, .box {
            margin-bottom: 20px;
            padding: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f3f4f6;
        }
        .print-btn {
            margin-bottom: 20px;
            padding: 10px 16px;
            border: none;
            background: #111827;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }
        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">Print Summary</button>

    <h1>SalaryCalc Pro - Printable Summary</h1>

    <div class="meta">
        <p><strong>User:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}</p>
    </div>

    <div class="box">
        <h2>Salary Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Experience</th>
                    <th>Location</th>
                    <th>Annual Gross Salary</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($calculations as $calc)
                    <tr>
                        <td>{{ $calc->job_title }}</td>
                        <td>{{ $calc->experience }} years</td>
                        <td>{{ $calc->location }}</td>
                        <td>£{{ number_format($calc->calculated_salary, 2) }}</td>
                        <td>{{ $calc->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>