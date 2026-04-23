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
            <p>Estimate your salary based on job role, experience, and location. Explore breakdowns, monthly take-home estimates, and smarter salary planning in one modern dashboard.</p>
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

                        <p class="result-note">
                            This is an estimated monthly take-home salary for project demonstration purposes.
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