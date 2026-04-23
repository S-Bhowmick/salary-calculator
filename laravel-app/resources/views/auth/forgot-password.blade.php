<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - SalaryCalc Pro</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-shell">
        <div class="auth-topbar">
            <a href="{{ url('/') }}" class="auth-brand">SalaryCalc Pro</a>

            <div class="auth-top-actions">
                <a href="{{ route('login') }}" class="nav-btn">Back to Login</a>
            </div>
        </div>

        <div class="auth-page">
            <div class="auth-hero-panel">
                <div>
                    <span class="auth-badge">Password Recovery</span>
                    <h1 class="auth-hero-title">Reset Your Access</h1>
                    <p class="auth-hero-text">
                        Enter your email address and we will send you a password reset link so you can access your salary dashboard again.
                    </p>

                    <div class="auth-feature-list">
                        <div class="auth-feature-item">
                            <h4>Secure Recovery</h4>
                            <p>Password reset is handled securely through Laravel authentication routes.</p>
                        </div>

                        <div class="auth-feature-item">
                            <h4>Quick Access</h4>
                            <p>Recover your account and continue using salary planning, comparison, and reports.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-form-panel">
                <h2 class="auth-form-title">Forgot Password</h2>
                <p class="auth-form-subtitle">
                    We’ll email you a reset link that lets you choose a new password.
                </p>

                @if (session('status'))
                    <div class="panel" style="padding:16px; margin-bottom:18px; border-color: rgba(34,197,94,0.25);">
                        <p style="color:#86efac; font-weight:700;">{{ session('status') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="auth-error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">

                    <button type="submit" class="calculate-btn auth-submit">Email Password Reset Link</button>

                    <p class="auth-bottom-text">
                        Remembered your password?
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