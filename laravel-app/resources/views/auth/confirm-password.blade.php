<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password - SalaryCalc Pro</title>
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
                    <span class="auth-badge">Security Check</span>
                    <h1 class="auth-hero-title">Confirm Your Password</h1>
                    <p class="auth-hero-text">
                        For security reasons, please confirm your password before accessing this protected area.
                    </p>

                    <div class="auth-feature-list">
                        <div class="auth-feature-item">
                            <h4>Extra Protection</h4>
                            <p>This prevents unauthorized access to sensitive settings and user account actions.</p>
                        </div>

                        <div class="auth-feature-item">
                            <h4>Safe Access</h4>
                            <p>Once confirmed, you can continue to secure sections of the application.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-form-panel">
                <h2 class="auth-form-title">Confirm Password</h2>
                <p class="auth-form-subtitle">
                    Enter your password to continue.
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

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">

                    <button type="submit" class="calculate-btn auth-submit">Confirm Password</button>
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