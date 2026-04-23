<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Comparison</title>
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
                <h1>Salary Comparison</h1>
                <p>Compare your selected salary records side by side to identify the best role, location, and expected earning path.</p>
            </div>

            <div class="top-actions">
                <a href="{{ route('dashboard') }}" class="top-action-btn">Back to Dashboard</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <p>Compared Records</p>
                <h3>{{ $comparisons->count() }}</h3>
            </div>

            <div class="stat-card">
                <p>Highest Compared Salary</p>
                <h3 class="text-green">£{{ number_format($comparisons->max('calculated_salary') ?? 0, 2) }}</h3>
            </div>

            <div class="stat-card">
                <p>Lowest Compared Salary</p>
                <h3 class="text-orange">£{{ number_format($comparisons->min('calculated_salary') ?? 0, 2) }}</h3>
            </div>

            <div class="stat-card">
                <p>Average Compared Salary</p>
                <h3 class="text-blue">£{{ number_format($comparisons->avg('calculated_salary') ?? 0, 2) }}</h3>
            </div>
        </div>

        <div class="panel">
            <div class="panel-title-row">
                <div>
                    <h2>Side-by-Side Comparison</h2>
                    <p class="panel-subtext">Review job title, experience, location, salary, and date in one premium comparison board.</p>
                </div>
            </div>

            <div class="table-wrap">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            @foreach($comparisons as $comparison)
                                <th>Record {{ $loop->iteration }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Job Title</strong></td>
                            @foreach($comparisons as $comparison)
                                <td>{{ $comparison->job_title }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Experience</strong></td>
                            @foreach($comparisons as $comparison)
                                <td>{{ $comparison->experience }} years</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Location</strong></td>
                            @foreach($comparisons as $comparison)
                                <td>{{ $comparison->location }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Calculated Salary</strong></td>
                            @foreach($comparisons as $comparison)
                                <td class="text-green">£{{ number_format($comparison->calculated_salary, 2) }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Date</strong></td>
                            @foreach($comparisons as $comparison)
                                <td>{{ $comparison->created_at->format('d M Y') }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td><strong>Best Salary</strong></td>
                            @foreach($comparisons as $comparison)
                                <td>
                                    @if($comparison->calculated_salary == $comparisons->max('calculated_salary'))
                                        <span class="status-pill active">Top Option</span>
                                    @else
                                        <span class="status-pill inactive" style="background:#475569;">Standard</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
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