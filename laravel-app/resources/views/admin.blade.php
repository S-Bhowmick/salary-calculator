<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">SalaryCalc Pro</div>

            <div class="nav-right">
                <span class="welcome-text">Welcome Admin, {{ Auth::user()->name }}</span>
                <a href="{{ route('home') }}" class="nav-btn">Home</a>
                <a href="{{ route('dashboard') }}" class="nav-btn">Dashboard</a>

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
                <h1>Admin Panel</h1>
                <p>Manage users, salary rules, locations, analytics, and overall application monitoring from one premium control center.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="panel" style="border-color: rgba(34,197,94,0.25);">
                <p style="color:#86efac; font-weight:700;">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="panel" style="border-color: rgba(239,68,68,0.25);">
                <ul style="padding-left:18px; color:#fecaca;">
                    @foreach($errors->all() as $error)
                        <li style="margin:6px 0;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <p>Total Users</p>
                <h3>{{ $totalUsers }}</h3>
            </div>

            <div class="stat-card">
                <p>Total Calculations</p>
                <h3 class="text-green">{{ $totalCalculations }}</h3>
            </div>

            <div class="stat-card">
                <p>Total Job Roles</p>
                <h3 class="text-purple">{{ $totalJobRoles }}</h3>
            </div>

            <div class="stat-card">
                <p>Total Locations</p>
                <h3 class="text-orange">{{ $totalLocations }}</h3>
            </div>

            <div class="stat-card">
                <p>Most Selected Role</p>
                <h3>{{ $mostSelectedJobRole?->job_title ?? 'N/A' }}</h3>
            </div>

            <div class="stat-card">
                <p>Most Selected Location</p>
                <h3>{{ $mostSelectedLocation?->location ?? 'N/A' }}</h3>
            </div>

            <div class="stat-card">
                <p>Average Salary</p>
                <h3 class="text-green">£{{ number_format($averageSalary, 2) }}</h3>
            </div>

            <div class="stat-card">
                <p>Highest Salary</p>
                <h3 class="text-green">£{{ number_format($highestSalary, 2) }}</h3>
            </div>

            <div class="stat-card">
                <p>Active Roles</p>
                <h3 class="text-purple">{{ $totalActiveRoles }}</h3>
            </div>

            <div class="stat-card">
                <p>Active Locations</p>
                <h3 class="text-orange">{{ $totalActiveLocations }}</h3>
            </div>
        </div>

        <div class="panel">
            <div class="panel-title-row">
                <div>
                    <h2>Admin Analytics Charts</h2>
                    <p class="panel-subtext">Visual overview of job role popularity and user account status.</p>
                </div>
            </div>

            <div class="chart-grid">
                <div class="chart-card">
                    <h3>Most Selected Job Roles</h3>
                    <canvas id="jobRoleBarChart" height="140"></canvas>
                </div>

                <div class="chart-card">
                    <h3>User Status Distribution</h3>
                    <canvas id="userStatusPieChart" height="140"></canvas>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-title-row">
                <h2>All Users</h2>
                <div class="top-actions">
                    <a href="{{ route('home') }}" class="top-action-btn">Back to Home</a>
                </div>
            </div>

            <div class="table-wrap">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin</th>
                            <th>Active</th>
                            <th>Calculation Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                                <td>
                                    <span class="status-pill {{ $user->is_active ? 'active' : 'inactive' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $user->salary_calculations_count }}</td>
                                <td>
                                    <div class="inline-actions">
                                        @if(!$user->is_admin)
                                            <form action="{{ route('admin.user.promote', $user->id) }}" method="POST" class="table-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="table-btn blue compact-btn">Promote Admin</button>
                                            </form>
                                        @endif

                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.user.toggle', $user->id) }}" method="POST" class="table-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="table-btn {{ $user->is_active ? 'red' : 'green' }} compact-btn">
                                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-title-row">
                <h2>Add New Job Role</h2>
            </div>

            <form action="{{ route('admin.jobrole.add') }}" method="POST" class="glass-form-grid">
                @csrf

                <div>
                    <label>Role Name</label>
                    <input type="text" name="role_name" class="glass-input" required>
                </div>

                <div>
                    <label>Base Salary</label>
                    <input type="number" name="base_salary" class="glass-input" min="0" required>
                </div>

                <div>
                    <label>Experience Increment</label>
                    <input type="number" name="experience_increment" class="glass-input" min="0" required>
                </div>

                <div>
                    <button type="submit" class="form-submit-btn">Add Job Role</button>
                </div>
            </form>
        </div>

        <div class="panel">
            <div class="panel-title-row">
                <h2>Job Roles & Salary Rules</h2>
            </div>

            <div class="table-wrap">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Role Name</th>
                            <th>Base Salary</th>
                            <th>Experience Increment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobRoles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->role_name }}</td>
                                <td>£{{ $role->base_salary }}</td>
                                <td>£{{ $role->experience_increment }}</td>
                                <td>
                                    <span class="status-pill {{ $role->is_active ? 'active' : 'inactive' }}">
                                        {{ $role->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.role.toggle', $role->id) }}" method="POST" class="table-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="table-btn {{ $role->is_active ? 'red' : 'green' }} compact-btn">
                                            {{ $role->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No job roles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-title-row">
                <h2>Add New Location Bonus</h2>
            </div>

            <form action="{{ route('admin.location.add') }}" method="POST" class="glass-form-grid">
                @csrf

                <div>
                    <label>Location Name</label>
                    <input type="text" name="location_name" class="glass-input" required>
                </div>

                <div>
                    <label>Bonus Amount</label>
                    <input type="number" name="bonus_amount" class="glass-input" min="0" required>
                </div>

                <div>
                    <label>Estimated Monthly Cost</label>
                    <input type="number" name="estimated_monthly_cost" class="glass-input" min="0" required>
                </div>

                <div>
                    <button type="submit" class="form-submit-btn orange">Add Location Bonus</button>
                </div>
            </form>
        </div>

        <div class="panel">
            <div class="panel-title-row">
                <h2>Location Bonuses</h2>
            </div>

            <div class="table-wrap">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Location Name</th>
                            <th>Bonus Amount</th>
                            <th>Est. Monthly Cost</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($locationBonuses as $location)
                            <tr>
                                <td>{{ $location->id }}</td>
                                <td>{{ $location->location_name }}</td>
                                <td>£{{ $location->bonus_amount }}</td>
                                <td>£{{ $location->estimated_monthly_cost }}</td>
                                <td>
                                    <span class="status-pill {{ $location->is_active ? 'active' : 'inactive' }}">
                                        {{ $location->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.location.toggle', $location->id) }}" method="POST" class="table-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="table-btn {{ $location->is_active ? 'red' : 'green' }} compact-btn">
                                            {{ $location->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No location bonuses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-title-row">
                <h2>All Salary Calculations</h2>
            </div>

            <div class="table-wrap">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Job Title</th>
                            <th>Experience</th>
                            <th>Location</th>
                            <th>Salary</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($calculations as $calc)
                            <tr>
                                <td>{{ $calc->user_id }}</td>
                                <td>{{ $calc->job_title }}</td>
                                <td>{{ $calc->experience }}</td>
                                <td>{{ $calc->location }}</td>
                                <td class="text-green">£{{ $calc->calculated_salary }}</td>
                                <td>
                                    <form action="{{ route('admin.calculation.delete', $calc->id) }}" method="POST" class="table-form" onsubmit="return confirm('Delete this calculation?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-btn red compact-btn">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No salary calculations found.</td>
                            </tr>
                        @endforelse
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const jobRoleLabels = @json($jobRoleChartData->pluck('job_title'));
        const jobRoleCounts = @json($jobRoleChartData->pluck('total'));

        const userStatusLabels = @json($userStatusChartLabels);
        const userStatusCounts = @json($userStatusChartData);

        const jobRoleBarCtx = document.getElementById('jobRoleBarChart');
        if (jobRoleBarCtx) {
            new Chart(jobRoleBarCtx, {
                type: 'bar',
                data: {
                    labels: jobRoleLabels,
                    datasets: [{
                        label: 'Selection Count',
                        data: jobRoleCounts,
                        backgroundColor: ['#9cff00', '#4ade80', '#22c55e', '#84cc16', '#bef264'],
                        borderRadius: 8
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
                            beginAtZero: true,
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
        }

        const userStatusPieCtx = document.getElementById('userStatusPieChart');
        if (userStatusPieCtx) {
            new Chart(userStatusPieCtx, {
                type: 'pie',
                data: {
                    labels: userStatusLabels,
                    datasets: [{
                        data: userStatusCounts,
                        backgroundColor: ['#16a34a', '#dc2626'],
                        borderColor: '#07110c',
                        borderWidth: 2
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
                    }
                }
            });
        }
    </script>

</body>
</html>