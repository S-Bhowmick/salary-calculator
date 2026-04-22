<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UK Salary Calculator</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">SalaryCalc Pro</div>
            <div class="nav-right">
                <span class="welcome-text">Welcome, {{ Auth::user()->name }}</span>
                <a href="{{ route('dashboard') }}" class="nav-btn">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>UK Salary Calculator</h1>
            <p>Estimate your salary based on job role, experience, and location. Built with Laravel.</p>
        </div>
    </section>

    <main class="main-container">
        <div class="card calculator-card">
            <h2>Calculate Your Salary</h2>

            <form action="{{ route('calculate.salary') }}" method="POST">
                @csrf

                <label for="jobTitle">Job Title</label>
                <select id="jobTitle" name="jobTitle" required>
                    <option value="Software Developer">Software Developer</option>
                    <option value="Data Analyst">Data Analyst</option>
                    <option value="Project Manager">Project Manager</option>
                </select>

                <label for="experience">Experience (Years)</label>
                <input type="number" id="experience" name="experience" min="0" required>

                <label for="location">Location</label>
                <select id="location" name="location" required>
                    <option value="London">London</option>
                    <option value="Manchester">Manchester</option>
                    <option value="Birmingham">Birmingham</option>
                </select>

                <button type="submit" class="calculate-btn">Calculate Salary</button>
            </form>

            @if(session('salary'))
                <div class="result-box success-box">
                    <h3>Estimated Salary</h3>
                    <p>£{{ session('salary') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="result-box error-box">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
        </div>
    </main>

</body>
</html>