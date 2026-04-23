<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Comparison</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">SalaryCalc Pro</div>

            <div class="nav-right">
                <span class="welcome-text">Welcome, {{ Auth::user()->name }}</span>
                <a href="{{ route('home') }}" class="nav-btn">Home</a>
                <a href="{{ route('dashboard') }}" class="nav-btn">Dashboard</a>

                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.panel') }}" class="nav-btn">Admin Panel</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="inline-form">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    @php
        $comparisonData = $comparisons->map(function ($comparison) use ($locationCosts) {
            $annualGross = $comparison->calculated_salary;
            $estimatedTax = $annualGross * 0.20;
            $estimatedNationalInsurance = $annualGross * 0.08;
            $estimatedPension = $annualGross * 0.05;
            $estimatedNetMonthly = ($annualGross - $estimatedTax - $estimatedNationalInsurance - $estimatedPension) / 12;
            $cityCost = $locationCosts[$comparison->location] ?? 0;
            $remainingAfterCityCost = $estimatedNetMonthly - $cityCost;

            return [
                'model' => $comparison,
                'net_monthly' => $estimatedNetMonthly,
                'city_cost' => $cityCost,
                'remaining_after_city_cost' => $remainingAfterCityCost,
            ];
        });

        $bestRemaining = $comparisonData->max('remaining_after_city_cost');
    @endphp

    <div class="page-shell">
        <div class="premium-header">
            <div class="premium-heading">
                <h1>Salary Comparison</h1>
                <p>Compare gross salary, estimated net monthly income, city cost-of-living, and remaining balance to decide which option is better for real life.</p>
            </div>

            <div class="top-actions">
                <a href="{{ route('dashboard') }}" class="top-action-btn">Back to Dashboard</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <p>Compared Records</p>
                <h3>{{ $comparisons->count() }}</h3>
            </div>

            <div class="stat-card">
                <p>Highest Gross Salary</p>
                <h3 class="text-green">£{{ number_format($comparisons->max('calculated_salary') ?? 0, 2) }}</h3>
            </div>

            <div class="stat-card">
                <p>Best Monthly Balance</p>
                <h3 class="text-blue">£{{ number_format($bestRemaining ?? 0, 2) }}</h3>
            </div>

            <div class="stat-card">
                <p>Average Net Monthly</p>
                <h3 class="text-orange">£{{ number_format($comparisonData->avg('net_monthly') ?? 0, 2) }}</h3>
            </div>
        </div>

        <div class="panel">
            <div class="panel-title-row">
                <div>
                    <h2>Net Salary Comparison</h2>
                    <p class="panel-subtext">Use this view to decide which job and city gives you the strongest real monthly outcome.</p>
                </div>
            </div>

            <div class="table-wrap">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            @foreach($comparisonData as $item)
                                <th>Record {{ $loop->iteration }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Job Title</strong></td>
                            @foreach($comparisonData as $item)
                                <td>{{ $item['model']->job_title }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Experience</strong></td>
                            @foreach($comparisonData as $item)
                                <td>{{ $item['model']->experience }} years</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Location</strong></td>
                            @foreach($comparisonData as $item)
                                <td>{{ $item['model']->location }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Annual Gross Salary</strong></td>
                            @foreach($comparisonData as $item)
                                <td class="text-green">£{{ number_format($item['model']->calculated_salary, 2) }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Estimated Net Monthly</strong></td>
                            @foreach($comparisonData as $item)
                                <td class="text-blue">£{{ number_format($item['net_monthly'], 2) }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>City Monthly Cost</strong></td>
                            @foreach($comparisonData as $item)
                                <td>£{{ number_format($item['city_cost'], 2) }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Remaining After City Cost</strong></td>
                            @foreach($comparisonData as $item)
                                <td class="text-orange">£{{ number_format($item['remaining_after_city_cost'], 2) }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Better Option</strong></td>
                            @foreach($comparisonData as $item)
                                <td>
                                    @if($item['remaining_after_city_cost'] == $bestRemaining)
                                        <span class="status-pill active">Best Choice</span>
                                    @else
                                        <span class="status-pill inactive" style="background:#475569;">Standard</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Date</strong></td>
                            @foreach($comparisonData as $item)
                                <td>{{ $item['model']->created_at->format('d M Y') }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="footer-wrap">
        <footer class="site-footer">
            <p><strong>Daffodil International University</strong></p>
            <p>Prepared by <strong>Surjya Bhowmick</strong></p>
            <p>Project developed for the <strong>Web Design Course</strong></p>
        </footer>
    </div>

</body>
</html>