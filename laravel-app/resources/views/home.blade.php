<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UK Salary Calculator</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">SalaryCalc Pro</div>

            <div class="nav-right">
                <span class="welcome-text">Welcome, {{ Auth::user()->name }}</span>

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

    <section class="hero">
        <div class="hero-content">
            <h1>UK Salary Calculator</h1>
            <p>Estimate salary, monthly take-home income, city affordability, savings potential, and smarter financial planning in one modern platform.</p>
        </div>
    </section>

    <main class="main-container">
        <div class="panel">
            <div class="panel-title-row">
                <div>
                    <h2>Getting Started</h2>
                    <p class="panel-subtext">A quick guide for first-time users to understand how this system works.</p>
                </div>
            </div>

            <div class="onboarding-grid">
                <div class="onboarding-card">
                    <h3>1. Choose a Job Role</h3>
                    <p>Select a role from the admin-managed job list. These roles are dynamic and can be updated by the admin panel.</p>
                </div>

                <div class="onboarding-card">
                    <h3>2. Enter Experience</h3>
                    <p>Your years of experience increase the salary based on the experience increment set for that role.</p>
                </div>

                <div class="onboarding-card">
                    <h3>3. Select a Location</h3>
                    <p>The chosen city adds a location bonus and also helps estimate monthly living affordability.</p>
                </div>

                <div class="onboarding-card">
                    <h3>4. Add Monthly Planning</h3>
                    <p>You can enter rent, food, transport, and other expenses to see your real remaining balance and savings potential.</p>
                </div>
            </div>
        </div>

        <div class="calculator-card">
            <div class="panel-title-row">
                <div>
                    <h2>Calculate Your Salary</h2>
                    <p class="panel-subtext">Use the form below to estimate salary and monthly financial planning.</p>
                </div>

            <div class="top-actions" style="margin-top:18px;">
                <a href="{{ route('report.download') }}" class="top-action-btn">Download PDF</a>
                <a href="{{ route('report.csv') }}" class="top-action-btn">Download CSV</a>
                <a href="{{ route('report.print') }}" class="top-action-btn secondary" target="_blank">Printable Summary</a>
            </div>

            <form action="{{ route('calculate.salary') }}" method="POST">
                @csrf

                <label for="jobTitle">Job Title</label>
                <select id="jobTitle" name="jobTitle" required>
                    <option value="">Select Job Role</option>
                    @foreach($jobRoles as $role)
                        <option value="{{ $role->role_name }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
                <p class="help-text">Choose the profession you want to evaluate. Job roles are managed from the admin panel.</p>

                <label for="experience">Experience (Years)</label>
                <input type="number" id="experience" name="experience" min="0" required>
                <p class="help-text">More experience increases salary according to the role’s configured yearly increment.</p>

                <label for="location">Location</label>
                <select id="location" name="location" required>
                    <option value="">Select Location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->location_name }}">{{ $location->location_name }}</option>
                    @endforeach
                </select>
                <p class="help-text">Different cities provide different location bonuses and living cost assumptions.</p>

                <div style="margin-top:24px; padding:18px; border:1px solid rgba(255,255,255,0.08); border-radius:18px; background:rgba(255,255,255,0.02);">
                    <h3 style="font-size:20px; font-weight:700; margin-bottom:8px; color:var(--text-main);">Monthly Planning (Optional)</h3>
                    <p style="font-size:14px; color:var(--text-soft); margin-bottom:16px;">Add your expected monthly expenses and a savings goal to see whether the salary works for your real life.</p>

                    <div class="glass-form-grid">
                        <div>
                            <label for="rent">Rent</label>
                            <input type="number" id="rent" name="rent" class="glass-input" min="0" placeholder="0">
                            <p class="help-text">Enter your expected monthly rent or housing cost.</p>
                        </div>

                        <div>
                            <label for="food">Food</label>
                            <input type="number" id="food" name="food" class="glass-input" min="0" placeholder="0">
                            <p class="help-text">Estimated monthly food and grocery cost.</p>
                        </div>

                        <div>
                            <label for="transport">Transport</label>
                            <input type="number" id="transport" name="transport" class="glass-input" min="0" placeholder="0">
                            <p class="help-text">Monthly travel or commuting expense.</p>
                        </div>

                        <div>
                            <label for="bills">Bills</label>
                            <input type="number" id="bills" name="bills" class="glass-input" min="0" placeholder="0">
                            <p class="help-text">Utility bills such as electricity, water, and internet.</p>
                        </div>

                        <div>
                            <label for="other">Other</label>
                            <input type="number" id="other" name="other" class="glass-input" min="0" placeholder="0">
                            <p class="help-text">Any extra monthly spending you want to include.</p>
                        </div>

                        <div>
                            <label for="savings_goal">Savings Goal</label>
                            <input type="number" id="savings_goal" name="savings_goal" class="glass-input" min="0" placeholder="0">
                            <p class="help-text">Target an amount and the system will estimate how many months it may take.</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="calculate-btn">Calculate Salary</button>
            </form>

            <div class="sample-box">
                <h3>Sample Calculation</h3>
                <p><strong>Job Role:</strong> Software Developer</p>
                <p><strong>Experience:</strong> 3 years</p>
                <p><strong>Location:</strong> London</p>
                <p><strong>Example Formula:</strong> Base Salary + (3 × Experience Increment) + Location Bonus</p>
                <p>This helps new users understand how the system generates salary and take-home estimations.</p>
            </div>

            @if(session('error'))
                <div class="result-box error-box">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if(session('salary'))
                <div class="result-grid">
                    <div class="result-card">
                        <h3 class="result-title">Salary Breakdown</h3>

                        <div class="result-item">
                            <span class="result-label">Base Salary</span>
                            <span class="result-value">£{{ number_format(session('base_salary'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Experience Bonus</span>
                            <span class="result-value">£{{ number_format(session('experience_bonus'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Location Bonus</span>
                            <span class="result-value">£{{ number_format(session('location_bonus'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Final Salary</span>
                            <span class="result-value">£{{ number_format(session('salary'), 2) }}</span>
                        </div>
                    </div>

                    <div class="result-card secondary">
                        <h3 class="result-title">Monthly Take-Home Estimate</h3>

                        <div class="result-item">
                            <span class="result-label">Annual Gross Salary</span>
                            <span class="result-value">£{{ number_format(session('annual_gross_salary'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Monthly Gross Salary</span>
                            <span class="result-value">£{{ number_format(session('monthly_gross_salary'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Estimated Tax</span>
                            <span class="result-value">£{{ number_format(session('estimated_tax'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Estimated National Insurance</span>
                            <span class="result-value">£{{ number_format(session('estimated_national_insurance'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Estimated Pension</span>
                            <span class="result-value">£{{ number_format(session('estimated_pension'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Estimated Net Monthly Salary</span>
                            <span class="result-value">£{{ number_format(session('estimated_net_monthly_salary'), 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="result-grid">
                    <div class="result-grid">
                        <div class="result-card">
                            <h3 class="result-title">Job Growth Forecast</h3>

                            <div class="result-item">
                                <span class="result-label">Salary After 1 Year</span>
                                <span class="result-value">£{{ number_format(session('salary_after_1_year'), 2) }}</span>
                            </div>

                            <div class="result-item">
                                <span class="result-label">Salary After 3 Years</span>
                                <span class="result-value">£{{ number_format(session('salary_after_3_years'), 2) }}</span>
                            </div>

                            <div class="result-item">
                                <span class="result-label">Salary After 5 Years</span>
                                <span class="result-value">£{{ number_format(session('salary_after_5_years'), 2) }}</span>
                            </div>

                            <p class="result-note">
                                This forecast uses the current role’s yearly experience increment and selected location bonus.
                            </p>
                        </div>

                        <div class="result-card secondary">
                            <h3 class="result-title">Personal Finance Dashboard</h3>

                            <div class="result-item">
                                <span class="result-label">Monthly Income</span>
                                <span class="result-value">£{{ number_format(session('estimated_net_monthly_salary'), 2) }}</span>
                            </div>

                            <div class="result-item">
                                <span class="result-label">Monthly Expenses</span>
                                <span class="result-value">£{{ number_format(session('total_monthly_expenses'), 2) }}</span>
                            </div>

                            <div class="result-item">
                                <span class="result-label">Savings Potential</span>
                                <span class="result-value">£{{ number_format(max(session('remaining_balance'), 0), 2) }}</span>
                            </div>

                            <div class="result-item">
                                <span class="result-label">Best Role/Location Recommendation</span>
                                <span class="result-value">
                                    @if(session('best_city_option'))
                                        {{ session('selected_role') }} - {{ session('best_city_option.location') }}
                                    @else
                                        Not available
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    @if(session('city_comparisons'))
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
                                    @foreach(session('city_comparisons') as $city)
                                        <tr>
                                            <td>{{ $city['location'] }}</td>
                                            <td>£{{ number_format($city['gross_salary'], 2) }}</td>
                                            <td class="text-blue">£{{ number_format($city['net_monthly'], 2) }}</td>
                                            <td>£{{ number_format($city['monthly_cost'], 2) }}</td>
                                            <td class="text-orange">£{{ number_format($city['remaining_balance'], 2) }}</td>
                                            <td>
                                                @if(session('best_city_option') && $city['location'] === session('best_city_option.location'))
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
                @endif
                    <div class="result-card">
                        <h3 class="result-title">Cost of Living by City</h3>

                        <div class="result-item">
                            <span class="result-label">Selected Location</span>
                            <span class="result-value">{{ session('selected_location') }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Estimated City Monthly Cost</span>
                            <span class="result-value">£{{ number_format(session('city_estimated_monthly_cost'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Net Monthly Salary</span>
                            <span class="result-value">£{{ number_format(session('estimated_net_monthly_salary'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Remaining After City Cost</span>
                            <span class="result-value">£{{ number_format(session('city_remaining_balance'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Can I Live in This City?</span>
                            <span class="result-value">{{ session('affordability_status') }}</span>
                        </div>
                    </div>

                    <div class="result-card secondary">
                        <h3 class="result-title">Monthly Expense Planner</h3>

                        <div class="result-item">
                            <span class="result-label">Rent</span>
                            <span class="result-value">£{{ number_format(session('rent'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Food</span>
                            <span class="result-value">£{{ number_format(session('food'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Transport</span>
                            <span class="result-value">£{{ number_format(session('transport'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Bills</span>
                            <span class="result-value">£{{ number_format(session('bills'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Other</span>
                            <span class="result-value">£{{ number_format(session('other'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Total Monthly Expenses</span>
                            <span class="result-value">£{{ number_format(session('total_monthly_expenses'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Remaining Balance</span>
                            <span class="result-value">£{{ number_format(session('remaining_balance'), 2) }}</span>
                        </div>
                    </div>

                    <div class="result-card">
                        <h3 class="result-title">Savings Goal Tracker</h3>

                        <div class="result-item">
                            <span class="result-label">Savings Goal</span>
                            <span class="result-value">£{{ number_format(session('savings_goal'), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Monthly Saving Potential</span>
                            <span class="result-value">£{{ number_format(max(session('remaining_balance'), 0), 2) }}</span>
                        </div>

                        <div class="result-item">
                            <span class="result-label">Months to Reach Goal</span>
                            <span class="result-value">
                                @if(session('savings_goal') > 0)
                                    @if(session('months_to_goal'))
                                        {{ session('months_to_goal') }} months
                                    @else
                                        Not reachable
                                    @endif
                                @else
                                    Not set
                                @endif
                            </span>
                        </div>

                        <p class="result-note">
                            Compare different roles and cities to find the option that gives you the best monthly balance and fastest savings growth.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <div class="footer-wrap">
        <footer class="site-footer">
            <p><strong>Daffodil International University</strong></p>
            <p>Prepared by <strong>Surjya Bhowmick</strong></p>
            <p>Project developed for the <strong>Web Design Course</strong></p>
        </footer>
    </div>

</body>
</html>