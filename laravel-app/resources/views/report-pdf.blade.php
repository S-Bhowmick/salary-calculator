<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>UK Salary Calculator Report</title>
    <style>
        @page {
            margin: 24px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
            margin: 0;
        }

        .header {
            text-align: center;
            padding-bottom: 14px;
            border-bottom: 2px solid #111827;
            margin-bottom: 20px;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 12px;
            color: #4b5563;
            margin-top: 2px;
        }

        .meta-box {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 18px;
            background: #f9fafb;
        }

        .meta-box p {
            margin: 4px 0;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #111827;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            margin-bottom: 16px;
        }

        .summary-card {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 12px;
            background: #f9fafb;
        }

        .summary-label {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #111827;
        }

        .takehome-box {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 14px;
            background: #f9fafb;
            margin-bottom: 18px;
        }

        .takehome-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .takehome-grid td {
            width: 50%;
            padding: 8px 6px;
            vertical-align: top;
        }

        .takehome-label {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .takehome-value {
            font-size: 15px;
            font-weight: bold;
            color: #111827;
        }

        .green {
            color: #166534;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .report-table th {
            background: #111827;
            color: white;
            font-size: 11px;
        }

        .report-table td {
            font-size: 11px;
        }

        .note-box {
            margin-top: 18px;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #f9fafb;
            font-size: 11px;
            color: #4b5563;
            line-height: 1.5;
        }

        .footer {
            margin-top: 24px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            border-top: 1px solid #d1d5db;
            padding-top: 12px;
        }

        .small {
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    @php
        $totalCalculations = $calculations->count();
        $latestSalary = $calculations->first()?->calculated_salary ?? 0;
        $highestSalary = $calculations->max('calculated_salary') ?? 0;
        $averageSalary = $calculations->avg('calculated_salary') ?? 0;

        $latestCalc = $calculations->first();

        if ($latestCalc) {
            $annualGross = $latestCalc->calculated_salary;
            $monthlyGross = $annualGross / 12;
            $estimatedTax = $annualGross * 0.20;
            $estimatedNationalInsurance = $annualGross * 0.08;
            $estimatedPension = $annualGross * 0.05;
            $estimatedNetMonthly = ($annualGross - $estimatedTax - $estimatedNationalInsurance - $estimatedPension) / 12;
        } else {
            $annualGross = 0;
            $monthlyGross = 0;
            $estimatedTax = 0;
            $estimatedNationalInsurance = 0;
            $estimatedPension = 0;
            $estimatedNetMonthly = 0;
        }
    @endphp

    <div class="header">
        <div class="brand">UK Salary Calculator Report</div>
        <div class="subtitle">Generated from SalaryCalc Pro</div>
        <div class="subtitle">Daffodil International University | Web Design Course</div>
    </div>

    <div class="meta-box">
        <p><strong>User Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Generated At:</strong> {{ now()->format('d M Y, h:i A') }}</p>
        <p><strong>Prepared By:</strong> Surjya Bhowmick</p>
    </div>

    <div class="section-title">Report Summary</div>

    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-card">
                    <div class="summary-label">Total Calculations</div>
                    <div class="summary-value">{{ $totalCalculations }}</div>
                </div>
            </td>
            <td>
                <div class="summary-card">
                    <div class="summary-label">Latest Salary</div>
                    <div class="summary-value">£{{ number_format($latestSalary, 2) }}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="summary-card">
                    <div class="summary-label">Highest Salary</div>
                    <div class="summary-value">£{{ number_format($highestSalary, 2) }}</div>
                </div>
            </td>
            <td>
                <div class="summary-card">
                    <div class="summary-label">Average Salary</div>
                    <div class="summary-value">£{{ number_format($averageSalary, 2) }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Latest Monthly Take-Home Estimate</div>

    <div class="takehome-box">
        <table class="takehome-grid">
            <tr>
                <td>
                    <div class="takehome-label">Annual Gross Salary</div>
                    <div class="takehome-value">£{{ number_format($annualGross, 2) }}</div>
                </td>
                <td>
                    <div class="takehome-label">Monthly Gross Salary</div>
                    <div class="takehome-value">£{{ number_format($monthlyGross, 2) }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="takehome-label">Estimated Tax</div>
                    <div class="takehome-value">£{{ number_format($estimatedTax, 2) }}</div>
                </td>
                <td>
                    <div class="takehome-label">Estimated National Insurance</div>
                    <div class="takehome-value">£{{ number_format($estimatedNationalInsurance, 2) }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="takehome-label">Estimated Pension</div>
                    <div class="takehome-value">£{{ number_format($estimatedPension, 2) }}</div>
                </td>
                <td>
                    <div class="takehome-label">Estimated Net Monthly Salary</div>
                    <div class="takehome-value green">£{{ number_format($estimatedNetMonthly, 2) }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Salary History</div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Experience</th>
                <th>Location</th>
                <th>Annual Gross</th>
                <th>Est. Net Monthly</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($calculations as $calc)
                @php
                    $rowAnnualGross = $calc->calculated_salary;
                    $rowEstimatedTax = $rowAnnualGross * 0.20;
                    $rowEstimatedNI = $rowAnnualGross * 0.08;
                    $rowEstimatedPension = $rowAnnualGross * 0.05;
                    $rowEstimatedNetMonthly = ($rowAnnualGross - $rowEstimatedTax - $rowEstimatedNI - $rowEstimatedPension) / 12;
                @endphp
                <tr>
                    <td>{{ $calc->job_title }}</td>
                    <td>{{ $calc->experience }} years</td>
                    <td>{{ $calc->location }}</td>
                    <td class="green"><strong>£{{ number_format($rowAnnualGross, 2) }}</strong></td>
                    <td class="green"><strong>£{{ number_format($rowEstimatedNetMonthly, 2) }}</strong></td>
                    <td>{{ $calc->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">No salary records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="note-box">
        <strong>Note:</strong> This report shows estimated salary and monthly take-home calculations for project demonstration purposes.
        Tax, national insurance, and pension values are simplified estimates and should not be treated as official UK payroll results.
    </div>

    <div class="footer">
        <p><strong>Daffodil International University</strong></p>
        <p>Prepared by <strong>Surjya Bhowmick</strong></p>
        <p>Project developed for the <strong>Web Design Course</strong></p>
        <p class="small">UK Salary Calculator | Laravel Project Report</p>
    </div>
</body>
</html>