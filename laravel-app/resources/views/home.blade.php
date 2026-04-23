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
        <div class="calculator-card">
            <h2>Calculate Your Salary</h2>

            <form action="{{ route('calculate.salary') }}" method="POST">
                @csrf

                <label for="jobTitle">Job Title</label>
                <select id="jobTitle" name="jobTitle" required>
                    <option value="">Select Job Role</option>
                    @foreach($jobRoles as $role)
                        <option value="{{ $role->role_name }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>

                <label for="experience">Experience (Years)</label>
                <input type="number" id="experience" name="experience" min="0" required>

                <label for="location">Location</label>
                <select id="location" name="location" required>
                    <option value="">Select Location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->location_name }}">{{ $location->location_name }}</option>
                    @endforeach
                </select>

                <div style="margin-top:24px; padding:18px; border:1px solid rgba(255,255,255,0.08); border-radius:18px; background:rgba(255,255,255,0.02);">
                    <h3 style="font-size:20px; font-weight:700; margin-bottom:8px; color:var(--text-main);">Monthly Planning (Optional)</h3>
                    <p style="font-size:14px; color:var(--text-soft); margin-bottom:16px;">Add your expected monthly expenses and a savings goal to see whether the salary works for your real life.</p>

                    <div class="glass-form-grid">
                        <div>
                            <label for="rent">Rent</label>
                            <input type="number" id="rent" name="rent" class="glass-input" min="0" placeholder="0">
                        </div>

                        <div>
                            <label for="food">Food</label>
                            <input type="number" id="food" name="food" class="glass-input" min="0" placeholder="0">
                        </div>

                        <div>
                            <label for="transport">Transport</label>
                            <input type="number" id="transport" name="transport" class="glass-input" min="0" placeholder="0">
                        </div>

                        <div>
                            <label for="bills">Bills</label>
                            <input type="number" id="bills" name="bills" class="glass-input" min="0" placeholder="0">
                        </div>

                        <div>
                            <label for="other">Other</label>
                            <input type="number" id="other" name="other" class="glass-input" min="0" placeholder="0">
                        </div>

                        <div>
                            <label for="savings_goal">Savings Goal</label>
                            <input type="number" id="savings_goal" name="savings_goal" class="glass-input" min="0" placeholder="0">
                        </div>
                    </div>
                </div>

                <button type="submit" class="calculate-btn">Calculate Salary</button>
            </form>

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