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
            <div class="panel-title-row" style="justify-content: center;">
                <div style="text-align: center; width: 100%;">
                    <h2>Calculate Your Salary</h2>
                    <p class="panel-subtext">Use the form below to estimate salary and monthly financial planning.</p>
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

                <div class="calc-split-layout">
                    <div class="calc-left-box">
                        <h3>Main Salary Inputs</h3>
                        <p class="calc-box-subtext">
                            Fill the main salary details here. This is the most important part for quick calculation.
                        </p>

                        <label for="jobTitle">Job Title</label>
                        <select id="jobTitle" name="jobTitle" required>
                            <option value="">Select Job Role</option>
                            @foreach($jobRoles as $role)
                                <option value="{{ $role->role_name }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                        <p class="help-text">Choose the profession you want to evaluate.</p>

                        <label for="experience">Experience (Years)</label>
                        <input type="number" id="experience" name="experience" min="0" required>
                        <p class="help-text">Your experience affects salary growth.</p>

                        <label for="location">Location</label>
                        <select id="location" name="location" required>
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->location_name }}">{{ $location->location_name }}</option>
                            @endforeach
                        </select>
                        <p class="help-text">Location affects both bonus and city affordability.</p>

                        <button type="submit" class="calculate-btn compact-submit">Calculate Salary</button>
                    </div>

                    <div class="calc-right-box">
                        <h3>Monthly Planning </h3>
                        <p class="calc-box-subtext">
                            Add your expected monthly expenses and savings goal to make the result more practical.
                        </p>

                        <div class="glass-form-grid">
                            <div>
                                <label for="rent">Rent</label>
                                <input type="number" id="rent" name="rent" class="glass-input" min="0" placeholder="0">
                                <p class="help-text">Monthly rent or housing cost.</p>
                            </div>

                            <div>
                                <label for="food">Food</label>
                                <input type="number" id="food" name="food" class="glass-input" min="0" placeholder="0">
                                <p class="help-text">Food and grocery cost.</p>
                            </div>

                            <div>
                                <label for="transport">Transport</label>
                                <input type="number" id="transport" name="transport" class="glass-input" min="0" placeholder="0">
                                <p class="help-text">Travel or commuting cost.</p>
                            </div>

                            <div>
                                <label for="bills">Bills</label>
                                <input type="number" id="bills" name="bills" class="glass-input" min="0" placeholder="0">
                                <p class="help-text">Utility and internet bills.</p>
                            </div>

                            <div>
                                <label for="other">Other</label>
                                <input type="number" id="other" name="other" class="glass-input" min="0" placeholder="0">
                                <p class="help-text">Extra monthly spending.</p>
                            </div>

                            <div>
                                <label for="savings_goal">Savings Goal</label>
                                <input type="number" id="savings_goal" name="savings_goal" class="glass-input" min="0" placeholder="0">
                                <p class="help-text">Target amount you want to save.</p>
                            </div>

                            <div style="margin-top: 20px;">
                                <button type="submit" class="calculate-btn compact-submit secondary-btn">
                                    Calculate with Planning
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

    <div class="footer-wrap">
        <footer class="site-footer">
            <p><strong>Daffodil International University</strong></p>
            <p>Prepared by <strong>Surjya Bhowmick</strong></p>
            <p>Project developed for the <strong>Web Design Course</strong></p>
        </footer>
    </div>

</body>
</html>