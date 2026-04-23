<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
                <a href="{{ route('report.download') }}" class="nav-btn">PDF Report</a>

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
                <h1>User Dashboard</h1>
                <p>Track your salary history, manage favorites, compare salary records, and download your salary report.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="panel" style="border-color: rgba(34,197,94,0.25);">
                <p style="color:#86efac; font-weight:700;">{{ session('success') }}</p>
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <p>Total Calculations</p>
                <h3>{{ $calculations->count() }}</h3>
            </div>

            <div class="stat-card">
                <p>Latest Salary</p>
                <h3 class="text-green">
                    @if($calculations->count() > 0)
                        £{{ $calculations->first()->calculated_salary }}
                    @else
                        £0
                    @endif
                </h3>
            </div>

            <div class="stat-card">
                <p>Favorites</p>
                <h3 class="text-orange">{{ $calculations->where('is_favorite', true)->count() }}</h3>
            </div>

            <div class="stat-card">
                <p>Highest Salary</p>
                <h3 class="text-blue">
                    @if($calculations->count() > 0)
                        £{{ $calculations->max('calculated_salary') }}
                    @else
                        £0
                    @endif
                </h3>
            </div>
        </div>

        @if($calculations->where('is_favorite', true)->count() > 0)
            <div class="panel">
                <div class="panel-title-row">
                    <h2>Favorite Calculations</h2>
                </div>

                <div class="favorite-grid">
                    @foreach($calculations->where('is_favorite', true) as $favorite)
                        <div class="favorite-card">
                            <p><strong>Job:</strong> {{ $favorite->job_title }}</p>
                            <p><strong>Location:</strong> {{ $favorite->location }}</p>
                            <p><strong>Experience:</strong> {{ $favorite->experience }} years</p>
                            <p><strong>Salary:</strong> <span class="text-green">£{{ $favorite->calculated_salary }}</span></p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="panel">
            <div class="panel-title-row">
                <h2>Salary Trend Chart</h2>
                <div class="top-actions">
                    <a href="{{ route('home') }}" class="top-action-btn">Back to Calculator</a>
                </div>
            </div>

            @if($calculations->count() > 0)
                <div class="chart-shell">
                    <canvas id="salaryChart" height="100"></canvas>
                </div>
            @else
                <div class="empty-box">
                    No chart data yet.
                </div>
            @endif
        </div>

        <div class="panel">
            <div class="panel-title-row">
                <div>
                    <h2>Salary History</h2>
                    <p class="panel-subtext">Select 2 or 3 records to compare them side by side.</p>
                </div>
            </div>

            @if($calculations->count() > 0)
                <form action="{{ route('calculations.compare') }}" method="POST">
                    @csrf

                    <div class="table-wrap">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Experience</th>
                                    <th>Location</th>
                                    <th>Salary</th>
                                    <th>Date</th>
                                    <th>Compare</th>
                                    <th>Favorite</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calculations as $calc)
                                    <tr>
                                        <td>{{ $calc->job_title }}</td>
                                        <td>{{ $calc->experience }} years</td>
                                        <td>{{ $calc->location }}</td>
                                        <td class="text-green">£{{ $calc->calculated_salary }}</td>
                                        <td>{{ $calc->created_at->format('d M Y') }}</td>
                                        <td>
                                            <input type="checkbox" name="selected_calculations[]" value="{{ $calc->id }}">
                                        </td>
                                        <td>
                                            <form action="{{ route('calculation.favorite', $calc->id) }}" method="POST" class="table-form">
                                                @csrf
                                                <button type="submit" class="table-btn {{ $calc->is_favorite ? 'orange' : 'gray' }}">
                                                    {{ $calc->is_favorite ? '★ Favorite' : '☆ Mark' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('calculation.delete', $calc->id) }}" method="POST" class="table-form" onsubmit="return confirm('Delete this calculation?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="table-btn red">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="compare-submit">
                        <button type="submit" class="table-btn blue">Compare Selected</button>
                    </div>
                </form>
            @else
                <div class="empty-box">
                    No salary calculations found yet.
                </div>
            @endif
        </div>
    </div>

    <div class="footer-wrap">
        <footer class="site-footer">
            <p><strong>Daffodil International University</strong></p>
            <p>Prepared by <strong>Surjya Bhowmick</strong></p>
            <p>Project developed for the <strong>Web Design Course</strong></p>
        </footer>
    </div>

    @if($calculations->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('salaryChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        @foreach($calculations->reverse() as $calc)
                            '{{ $calc->created_at->format("d M") }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Calculated Salary',
                        data: [
                            @foreach($calculations->reverse() as $calc)
                                {{ $calc->calculated_salary }},
                            @endforeach
                        ],
                        fill: false,
                        borderColor: '#9cff00',
                        backgroundColor: '#9cff00',
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#f8fafc'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#b8c4be'
                            },
                            grid: {
                                color: 'rgba(255,255,255,0.06)'
                            }
                        },
                        y: {
                            ticks: {
                                color: '#b8c4be'
                            },
                            grid: {
                                color: 'rgba(255,255,255,0.06)'
                            }
                        }
                    }
                }
            });
        </script>
    @endif

</body>
</html>