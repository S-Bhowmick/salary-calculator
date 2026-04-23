<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SalaryCalc Pro</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-shell">
        <div class="auth-topbar">
            <a href="{{ url('/') }}" class="auth-brand">SalaryCalc Pro</a>

            <div class="auth-top-actions">
                <a href="{{ route('login') }}" class="nav-btn">Already Registered?</a>
            </div>
        </div>

        <div class="auth-page">
            <div class="auth-hero-panel">
                <div>
                    <span class="auth-badge">Create Your Account</span>
                    <h1 class="auth-hero-title">Start Smart Salary Planning</h1>
                    <p class="auth-hero-text">
                        Create your account to calculate salary, estimate monthly take-home income, compare roles, save favorites, and track salary growth through a premium experience.
                    </p>

                    <div class="auth-feature-list">
                        <div class="auth-feature-item">
                            <h4>Dynamic Salary Rules</h4>
                            <p>Job roles and location bonuses are controlled from the admin panel for flexible salary logic.</p>
                        </div>

                        <div class="auth-feature-item">
                            <h4>Take-Home Estimator</h4>
                            <p>Understand monthly salary impact with estimated deductions and net monthly pay.</p>
                        </div>

                        <div class="auth-feature-item">
                            <h4>Favorites & Comparison</h4>
                            <p>Save important records and compare multiple salary options side by side.</p>
                        </div>

                        <div class="auth-feature-item">
                            <h4>PDF Reporting</h4>
                            <p>Download salary history reports for documentation, review, and presentation.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-form-panel">
                <h2 class="auth-form-title">Register</h2>
                <p class="auth-form-subtitle">
                    Create your account to access the salary calculator, dashboard, and smart financial planning tools.
                </p>

                @if ($errors->any())
                    <div class="auth-error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <label for="name">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name">

                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email">

                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a password">

                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">

                    <button type="submit" class="calculate-btn auth-submit">Create Account</button>

                    <p class="auth-bottom-text">
                        Already have an account?
                        <a href="{{ route('login') }}">Login here</a>
                    </p>
                </form>
            </div>
        </div>

        <div class="footer-wrap">
            <footer class="site-footer">
                <p><strong>Daffodil International University</strong></p>
                <p>Prepared by <strong>Surjya Bhowmick</strong></p>
                <p>Project developed for the <strong>Web Design Course</strong></p>
            </footer>
        </div>
    </div>
</body>
</html>