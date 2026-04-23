<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - SalaryCalc Pro</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-shell">
        <div class="auth-topbar">
            <a href="{{ url('/') }}" class="auth-brand">SalaryCalc Pro</a>

            <div class="auth-top-actions">
                <a href="{{ route('dashboard') }}" class="nav-btn">Dashboard</a>
            </div>
        </div>

        <div class="auth-page">
            <div class="auth-hero-panel">
                <div>
                    <span class="auth-badge">Email Verification</span>
                    <h1 class="auth-hero-title">Verify Your Email</h1>
                    <p class="auth-hero-text">
                        Before continuing, please verify your email address by clicking the link we sent you.
                    </p>

                    <div class="auth-feature-list">
                        <div class="auth-feature-item">
                            <h4>Account Security</h4>
                            <p>Email verification helps protect your account and confirms your identity.</p>
                        </div>

                        <div class="auth-feature-item">
                            <h4>Quick Resend</h4>
                            <p>If you didn’t receive the email, you can request another verification link.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-form-panel">
                <h2 class="auth-form-title">Verify Email</h2>
                <p class="auth-form-subtitle">
                    Check your inbox and click the verification link to continue.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="panel" style="padding:16px; margin-bottom:18px; border-color: rgba(34,197,94,0.25);">
                        <p style="color:#86efac; font-weight:700;">
                            A new verification link has been sent to your email address.
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="calculate-btn auth-submit">Resend Verification Email</button>
                </form>

                <div class="auth-row">
                    <form method="POST" action="{{ route('logout') }}" class="inline-form">
                        @csrf
                        <button type="submit" class="nav-btn">Log Out</button>
                    </form>
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
    </div>
</body>
</html>