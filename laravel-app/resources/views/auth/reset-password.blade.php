<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SalaryCalc Pro</title>
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
                    <span class="auth-badge">New Password Setup</span>
                    <h1 class="auth-hero-title">Create a New Password</h1>
                    <p class="auth-hero-text">
                        Set a strong new password to secure your account and continue using the platform safely.
                    </p>

                    <div class="auth-feature-list">
                        <div class="auth-feature-item">
                            <h4>Secure Account</h4>
                            <p>Protect your salary records, PDF reports, favorites, and personal dashboard access.</p>
                        </div>

                        <div class="auth-feature-item">
                            <h4>Fast Recovery</h4>
                            <p>Once reset, you can log back in immediately and continue your work.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-form-panel">
                <h2 class="auth-form-title">Reset Password</h2>
                <p class="auth-form-subtitle">
                    Choose a new password for your account.
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

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="Enter your email">

                    <label for="password">New Password</label>
                    <input id="password" type="password" name="password" required placeholder="Enter new password">

                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirm new password">

                    <button type="submit" class="calculate-btn auth-submit">Reset Password</button>
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