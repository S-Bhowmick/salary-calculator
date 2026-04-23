<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Result</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">SalaryCalc Pro</div>

            <div class="nav-right">
                <span class="welcome-text">Welcome, {{ Auth::user()->name }}</span>
                <a href="{{ route('home') }}" class="nav-btn">New Calculation</a>
                <a href="{{ route('dashboard') }}" class="nav-btn">Dashboard</a>
                <a href="{{ route('faq') }}" class="nav-btn">FAQ</a>

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

    <div class="page-shell">
        <div class="premium-header">
            <div class="premium-heading">
                <h1>Salary Result</h1>
                <p>Here is your complete salary, take-home, planning, and comparison analysis.</p>
            </div>
        </div>

        <div class="export-actions">
            <a href="{{ route('report.download') }}" class="top-action-btn">Download PDF</a>
            <a href="{{ route('report.csv') }}" class="top-action-btn">Download CSV</a>
            <a href="{{ route('report.print') }}" class="top-action-btn secondary" target="_blank">Printable Summary</a>
        </div>

        <div class="result-grid">
            <div class="result-card">
                <h3 class="result-title">Salary Breakdown</h3>

                <div class="result-item">
                    <span class="result-label">Base Salary</span>
                    <span class="result-value">£{{ number_format($base_salary, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Experience Bonus</span>
                    <span class="result-value">£{{ number_format($experience_bonus, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Location Bonus</span>
                    <span class="result-value">£{{ number_format($location_bonus, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Final Salary</span>
                    <span class="result-value">£{{ number_format($salary, 2) }}</span>
                </div>
            </div>

            <div class="result-card secondary">
                <h3 class="result-title">Monthly Take-Home Estimate</h3>

                <div class="result-item">
                    <span class="result-label">Annual Gross Salary</span>
                    <span class="result-value">£{{ number_format($annual_gross_salary, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Monthly Gross Salary</span>
                    <span class="result-value">£{{ number_format($monthly_gross_salary, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Estimated Tax</span>
                    <span class="result-value">£{{ number_format($estimated_tax, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Estimated National Insurance</span>
                    <span class="result-value">£{{ number_format($estimated_national_insurance, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Estimated Pension</span>
                    <span class="result-value">£{{ number_format($estimated_pension, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Estimated Net Monthly Salary</span>
                    <span class="result-value">£{{ number_format($estimated_net_monthly_salary, 2) }}</span>
                </div>
            </div>

            <div class="result-card">
                <h3 class="result-title">Job Growth Forecast</h3>

                <div class="result-item">
                    <span class="result-label">Salary After 1 Year</span>
                    <span class="result-value">£{{ number_format($salary_after_1_year, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Salary After 3 Years</span>
                    <span class="result-value">£{{ number_format($salary_after_3_years, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Salary After 5 Years</span>
                    <span class="result-value">£{{ number_format($salary_after_5_years, 2) }}</span>
                </div>
            </div>

            <div class="result-card secondary">
                <h3 class="result-title">Personal Finance Dashboard</h3>

                <div class="result-item">
                    <span class="result-label">Monthly Income</span>
                    <span class="result-value">£{{ number_format($estimated_net_monthly_salary, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Monthly Expenses</span>
                    <span class="result-value">£{{ number_format($total_monthly_expenses, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Savings Potential</span>
                    <span class="result-value">£{{ number_format(max($remaining_balance, 0), 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Best Role/Location Recommendation</span>
                    <span class="result-value">
                        @if($best_city_option)
                            {{ $selected_role }} - {{ $best_city_option['location'] }}
                        @else
                            Not available
                        @endif
                    </span>
                </div>
            </div>

            <div class="result-card">
                <h3 class="result-title">Cost of Living by City</h3>

                <div class="result-item">
                    <span class="result-label">Selected Location</span>
                    <span class="result-value">{{ $selected_location }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Estimated City Monthly Cost</span>
                    <span class="result-value">£{{ number_format($city_estimated_monthly_cost, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Net Monthly Salary</span>
                    <span class="result-value">£{{ number_format($estimated_net_monthly_salary, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Remaining After City Cost</span>
                    <span class="result-value">£{{ number_format($city_remaining_balance, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Can I Live in This City?</span>
                    <span class="result-value">{{ $affordability_status }}</span>
                </div>
            </div>

            <div class="result-card secondary">
                <h3 class="result-title">Monthly Expense Planner</h3>

                <div class="result-item">
                    <span class="result-label">Rent</span>
                    <span class="result-value">£{{ number_format($rent, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Food</span>
                    <span class="result-value">£{{ number_format($food, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Transport</span>
                    <span class="result-value">£{{ number_format($transport, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Bills</span>
                    <span class="result-value">£{{ number_format($bills, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Other</span>
                    <span class="result-value">£{{ number_format($other, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Total Monthly Expenses</span>
                    <span class="result-value">£{{ number_format($total_monthly_expenses, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Remaining Balance</span>
                    <span class="result-value">£{{ number_format($remaining_balance, 2) }}</span>
                </div>
            </div>

            <div class="result-card">
                <h3 class="result-title">Savings Goal Tracker</h3>

                <div class="result-item">
                    <span class="result-label">Savings Goal</span>
                    <span class="result-value">£{{ number_format($savings_goal, 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Monthly Saving Potential</span>
                    <span class="result-value">£{{ number_format(max($remaining_balance, 0), 2) }}</span>
                </div>

                <div class="result-item">
                    <span class="result-label">Months to Reach Goal</span>
                    <span class="result-value">
                        @if($savings_goal > 0)
                            @if($monthsToGoal)
                                {{ $monthsToGoal }} months
                            @else
                                Not reachable
                            @endif
                        @else
                            Not set
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="panel" style="margin-top:24px;">
            <div class="panel-title-row">
                <div>
                    <h2>Compare Cities</h2>
                    <p class="panel-subtext">Same role, different city, different lifestyle outcome.</p>
                </div>
            </div>

            <div class="table-wrap">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>City</th>
                            <th>Annual Gross</th>
                            <th>Net Monthly</th>
                            <th>Monthly Cost</th>
                            <th>Remaining Balance</th>
                            <th>Recommendation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($city_comparisons as $city)
                            <tr>
                                <td>{{ $city['location'] }}</td>
                                <td>£{{ number_format($city['gross_salary'], 2) }}</td>
                                <td class="text-blue">£{{ number_format($city['net_monthly'], 2) }}</td>
                                <td>£{{ number_format($city['monthly_cost'], 2) }}</td>
                                <td class="text-orange">£{{ number_format($city['remaining_balance'], 2) }}</td>
                                <td>
                                    @if($best_city_option && $city['location'] === $best_city_option['location'])
                                        <span class="status-pill active">Best Choice</span>
                                    @else
                                        <span class="status-pill inactive" style="background:#475569;">Alternative</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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