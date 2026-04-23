<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SalaryCalc Pro</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-shell">
        <div class="auth-topbar">
            <a href="{{ url('/') }}" class="auth-brand">SalaryCalc Pro</a>

            <div class="auth-top-actions">
                <a href="{{ route('register') }}" class="nav-btn">Create Account</a>
            </div>
        </div>

        <div class="auth-page">
            <div class="auth-hero-panel">
                <div>
                    <span class="auth-badge">UK Salary Planning Platform</span>
                    <h1 class="auth-hero-title">Welcome Back</h1>
                    <p class="auth-hero-text">
                        Sign in to access your salary dashboard, comparison tools, PDF reports, favorites, and smart monthly salary planning features.
                    </p>

                    <div class="auth-feature-list">
                        <div class="auth-feature-item">
                            <h4>Salary Breakdown</h4>
                            <p>View base salary, experience bonus, location bonus, and final gross salary clearly.</p>
                        </div>

                        <div class="auth-feature-item">
                            <h4>Monthly Take-Home</h4>
                            <p>Estimate monthly gross pay, tax, national insurance, pension, and net monthly income.</p>
                        </div>

                        <div class="auth-feature-item">
                            <h4>Comparison Tools</h4>
                            <p>Compare salary records side by side to choose the best role and location.</p>
                        </div>

                        <div class="auth-feature-item">
                            <h4>Admin Analytics</h4>
                            <p>Admins can manage users, salary rules, analytics, active roles, and locations.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-form-panel">
                <h2 class="auth-form-title">Login</h2>
                <p class="auth-form-subtitle">
                    Enter your account details to continue to your premium salary planning dashboard.
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

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email">

                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">

                    <label class="auth-remember">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>

                    <button type="submit" class="calculate-btn auth-submit">Login</button>

                    <div class="auth-row">
                        @if (Route::has('password.request'))
                            <a class="auth-helper-link" href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <p class="auth-bottom-text">
                        Don’t have an account?
                        <a href="{{ route('register') }}">Register here</a>
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