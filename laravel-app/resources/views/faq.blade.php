<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - SalaryCalc Pro</title>
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

    <div class="page-shell">
        <div class="premium-header">
            <div class="premium-heading">
                <h1>Frequently Asked Questions</h1>
                <p>Quick answers to help users understand salary calculation, monthly planning, and comparison features.</p>
            </div>
        </div>

        <div class="panel">
            <div class="faq-list">
                <div class="faq-item">
                    <h3>How is salary calculated?</h3>
                    <p>Salary is calculated using the formula: Base Salary + (Experience × Experience Increment) + Location Bonus.</p>
                </div>

                <div class="faq-item">
                    <h3>Who controls the salary values?</h3>
                    <p>The admin manages job roles, salary rules, location bonuses, and city monthly living cost values through the admin panel.</p>
                </div>

                <div class="faq-item">
                    <h3>What is monthly take-home estimate?</h3>
                    <p>It is an estimated monthly income after simplified deductions for tax, national insurance, and pension, shown for project demonstration purposes.</p>
                </div>

                <div class="faq-item">
                    <h3>How do I know if I can live in a city?</h3>
                    <p>The system compares your estimated net monthly salary with the configured monthly cost of living for the selected city.</p>
                </div>

                <div class="faq-item">
                    <h3>What does the savings goal tracker do?</h3>
                    <p>It estimates how many months it may take to reach your target savings based on your remaining balance after monthly expenses.</p>
                </div>

                <div class="faq-item">
                    <h3>How can I compare job options?</h3>
                    <p>From the dashboard, select 2 or 3 saved salary records and use the comparison feature to review which one gives a better monthly outcome.</p>
                </div>
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