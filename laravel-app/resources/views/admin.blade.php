<x-app-layout>
    <div style="min-height: 100vh; background: linear-gradient(135deg, #eef2ff, #f8fafc); padding: 30px 20px 60px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <div style="
                background: white;
                border-radius: 24px;
                padding: 30px;
                box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10);
                border: 1px solid #e2e8f0;
                margin-bottom: 25px;
            ">
                <h1 style="font-size: 34px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                    Admin Panel
                </h1>
                <p style="color: #475569; font-size: 16px;">
                    Welcome Admin, {{ Auth::user()->name }}. Manage users, salary rules, locations, and salary records here.
                </p>
            </div>

            @if(session('success'))
                <div style="
                    background: #ecfdf5;
                    border: 1px solid #86efac;
                    color: #166534;
                    padding: 16px 20px;
                    border-radius: 16px;
                    margin-bottom: 20px;
                    font-weight: 600;
                ">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="
                    background: #fef2f2;
                    border: 1px solid #fca5a5;
                    color: #b91c1c;
                    padding: 16px 20px;
                    border-radius: 16px;
                    margin-bottom: 20px;
                    font-weight: 600;
                ">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach($errors->all() as $error)
                            <li style="margin:4px 0;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 20px;
                margin-bottom: 25px;
            ">
                <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Total Users</p>
                    <h2 style="font-size: 30px; font-weight: 700; color: #0f172a;">{{ $totalUsers }}</h2>
                </div>

                <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Total Calculations</p>
                    <h2 style="font-size: 30px; font-weight: 700; color: #16a34a;">{{ $totalCalculations }}</h2>
                </div>

                <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Total Job Roles</p>
                    <h2 style="font-size: 30px; font-weight: 700; color: #7c3aed;">{{ $totalJobRoles }}</h2>
                </div>

                <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Total Locations</p>
                    <h2 style="font-size: 30px; font-weight: 700; color: #ea580c;">{{ $totalLocations }}</h2>
                </div>

                <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Most Selected Role</p>
                    <h2 style="font-size: 22px; font-weight: 700; color: #0f172a;">
                        {{ $mostSelectedJobRole?->job_title ?? 'N/A' }}
                    </h2>
                </div>

                <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Most Selected Location</p>
                    <h2 style="font-size: 22px; font-weight: 700; color: #0f172a;">
                        {{ $mostSelectedLocation?->location ?? 'N/A' }}
                    </h2>
                </div>

                <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Average Salary</p>
                    <h2 style="font-size: 22px; font-weight: 700; color: #16a34a;">
                        £{{ number_format($averageSalary, 2) }}
                    </h2>
                </div>

                <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Highest Salary</p>
                    <h2 style="font-size: 22px; font-weight: 700; color: #16a34a;">
                        £{{ number_format($highestSalary, 2) }}
                    </h2>
                </div>

                <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Active Roles</p>
                    <h2 style="font-size: 22px; font-weight: 700; color: #7c3aed;">
                        {{ $totalActiveRoles }}
                    </h2>
                </div>

                <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Active Locations</p>
                    <h2 style="font-size: 22px; font-weight: 700; color: #ea580c;">
                        {{ $totalActiveLocations }}
                    </h2>
                </div>
            </div>

            <div style="background: white; border-radius: 24px; padding: 30px; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10); border: 1px solid #e2e8f0; margin-bottom: 25px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
                    <h2 style="font-size: 26px; font-weight: 700; color: #0f172a;">All Users</h2>
                    <a href="{{ url('/') }}" style="text-decoration:none; background:#2563eb; color:white; padding:10px 16px; border-radius:12px; font-size:14px; font-weight:600;">
                        Back to Home
                    </a>
                </div>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background:#0f172a; color:white;">
                                <th style="padding:14px; text-align:left;">ID</th>
                                <th style="padding:14px; text-align:left;">Name</th>
                                <th style="padding:14px; text-align:left;">Email</th>
                                <th style="padding:14px; text-align:left;">Admin</th>
                                <th style="padding:14px; text-align:left;">Active</th>
                                <th style="padding:14px; text-align:left;">Calculation Count</th>
                                <th style="padding:14px; text-align:left;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr style="border-bottom:1px solid #e2e8f0;">
                                    <td style="padding:14px;">{{ $user->id }}</td>
                                    <td style="padding:14px;">{{ $user->name }}</td>
                                    <td style="padding:14px;">{{ $user->email }}</td>
                                    <td style="padding:14px;">{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                                    <td style="padding:14px;">
                                        <span style="
                                            padding:6px 10px;
                                            border-radius:999px;
                                            font-size:12px;
                                            font-weight:700;
                                            color:white;
                                            background: {{ $user->is_active ? '#16a34a' : '#dc2626' }};
                                        ">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td style="padding:14px;">{{ $user->salary_calculations_count }}</td>
                                    <td style="padding:14px;">
                                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                            @if(!$user->is_admin)
                                                <form action="{{ route('admin.user.promote', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" style="
                                                        background:#2563eb;
                                                        color:white;
                                                        border:none;
                                                        padding:8px 12px;
                                                        border-radius:10px;
                                                        font-size:13px;
                                                        font-weight:600;
                                                        cursor:pointer;
                                                    ">
                                                        Promote Admin
                                                    </button>
                                                </form>
                                            @endif

                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.user.toggle', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" style="
                                                        background: {{ $user->is_active ? '#dc2626' : '#16a34a' }};
                                                        color:white;
                                                        border:none;
                                                        padding:8px 12px;
                                                        border-radius:10px;
                                                        font-size:13px;
                                                        font-weight:600;
                                                        cursor:pointer;
                                                    ">
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

            <div style="background: white; border-radius: 24px; padding: 30px; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10); border: 1px solid #e2e8f0; margin-bottom: 25px;">
                <h2 style="font-size: 26px; font-weight: 700; color: #0f172a; margin-bottom: 20px;">Add New Job Role</h2>

                <form action="{{ route('admin.jobrole.add') }}" method="POST" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; align-items:end;">
                    @csrf

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155;">Role Name</label>
                        <input type="text" name="role_name" required style="width:100%; padding:12px 14px; border:1px solid #cbd5e1; border-radius:12px;">
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155;">Base Salary</label>
                        <input type="number" name="base_salary" min="0" required style="width:100%; padding:12px 14px; border:1px solid #cbd5e1; border-radius:12px;">
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155;">Experience Increment</label>
                        <input type="number" name="experience_increment" min="0" required style="width:100%; padding:12px 14px; border:1px solid #cbd5e1; border-radius:12px;">
                    </div>

                    <div>
                        <button type="submit" style="background:#2563eb; color:white; border:none; padding:12px 18px; border-radius:12px; font-size:14px; font-weight:600; cursor:pointer; width:100%;">
                            Add Job Role
                        </button>
                    </div>
                </form>
            </div>

            <div style="background: white; border-radius: 24px; padding: 30px; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10); border: 1px solid #e2e8f0; margin-bottom: 25px;">
                <h2 style="font-size: 26px; font-weight: 700; color: #0f172a; margin-bottom: 20px;">Job Roles & Salary Rules</h2>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background:#0f172a; color:white;">
                                <th style="padding:14px; text-align:left;">ID</th>
                                <th style="padding:14px; text-align:left;">Role Name</th>
                                <th style="padding:14px; text-align:left;">Base Salary</th>
                                <th style="padding:14px; text-align:left;">Experience Increment</th>
                                <th style="padding:14px; text-align:left;">Status</th>
                                <th style="padding:14px; text-align:left;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobRoles as $role)
                                <tr style="border-bottom:1px solid #e2e8f0;">
                                    <td style="padding:14px;">{{ $role->id }}</td>
                                    <td style="padding:14px;">{{ $role->role_name }}</td>
                                    <td style="padding:14px;">£{{ $role->base_salary }}</td>
                                    <td style="padding:14px;">£{{ $role->experience_increment }}</td>
                                    <td style="padding:14px;">
                                        <span style="
                                            padding:6px 10px;
                                            border-radius:999px;
                                            font-size:12px;
                                            font-weight:700;
                                            color:white;
                                            background: {{ $role->is_active ? '#16a34a' : '#dc2626' }};
                                        ">
                                            {{ $role->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td style="padding:14px;">
                                        <form action="{{ route('admin.role.toggle', $role->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" style="
                                                background: {{ $role->is_active ? '#dc2626' : '#16a34a' }};
                                                color:white;
                                                border:none;
                                                padding:8px 12px;
                                                border-radius:10px;
                                                font-size:13px;
                                                font-weight:600;
                                                cursor:pointer;
                                            ">
                                                {{ $role->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding:14px; text-align:center; color:#64748b;">No job roles found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="background: white; border-radius: 24px; padding: 30px; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10); border: 1px solid #e2e8f0; margin-bottom: 25px;">
                <h2 style="font-size: 26px; font-weight: 700; color: #0f172a; margin-bottom: 20px;">Add New Location Bonus</h2>

                <form action="{{ route('admin.location.add') }}" method="POST" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; align-items:end;">
                    @csrf

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155;">Location Name</label>
                        <input type="text" name="location_name" required style="width:100%; padding:12px 14px; border:1px solid #cbd5e1; border-radius:12px;">
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155;">Bonus Amount</label>
                        <input type="number" name="bonus_amount" min="0" required style="width:100%; padding:12px 14px; border:1px solid #cbd5e1; border-radius:12px;">
                    </div>

                    <div>
                        <button type="submit" style="background:#ea580c; color:white; border:none; padding:12px 18px; border-radius:12px; font-size:14px; font-weight:600; cursor:pointer; width:100%;">
                            Add Location Bonus
                        </button>
                    </div>
                </form>
            </div>

            <div style="background: white; border-radius: 24px; padding: 30px; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10); border: 1px solid #e2e8f0; margin-bottom: 25px;">
                <h2 style="font-size: 26px; font-weight: 700; color: #0f172a; margin-bottom: 20px;">Location Bonuses</h2>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background:#0f172a; color:white;">
                                <th style="padding:14px; text-align:left;">ID</th>
                                <th style="padding:14px; text-align:left;">Location Name</th>
                                <th style="padding:14px; text-align:left;">Bonus Amount</th>
                                <th style="padding:14px; text-align:left;">Status</th>
                                <th style="padding:14px; text-align:left;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locationBonuses as $location)
                                <tr style="border-bottom:1px solid #e2e8f0;">
                                    <td style="padding:14px;">{{ $location->id }}</td>
                                    <td style="padding:14px;">{{ $location->location_name }}</td>
                                    <td style="padding:14px;">£{{ $location->bonus_amount }}</td>
                                    <td style="padding:14px;">
                                        <span style="
                                            padding:6px 10px;
                                            border-radius:999px;
                                            font-size:12px;
                                            font-weight:700;
                                            color:white;
                                            background: {{ $location->is_active ? '#16a34a' : '#dc2626' }};
                                        ">
                                            {{ $location->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td style="padding:14px;">
                                        <form action="{{ route('admin.location.toggle', $location->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" style="
                                                background: {{ $location->is_active ? '#dc2626' : '#16a34a' }};
                                                color:white;
                                                border:none;
                                                padding:8px 12px;
                                                border-radius:10px;
                                                font-size:13px;
                                                font-weight:600;
                                                cursor:pointer;
                                            ">
                                                {{ $location->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding:14px; text-align:center; color:#64748b;">No location bonuses found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="background: white; border-radius: 24px; padding: 30px; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10); border: 1px solid #e2e8f0;">
                <h2 style="font-size: 26px; font-weight: 700; color: #0f172a; margin-bottom: 20px;">All Salary Calculations</h2>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background:#0f172a; color:white;">
                                <th style="padding:14px; text-align:left;">User ID</th>
                                <th style="padding:14px; text-align:left;">Job Title</th>
                                <th style="padding:14px; text-align:left;">Experience</th>
                                <th style="padding:14px; text-align:left;">Location</th>
                                <th style="padding:14px; text-align:left;">Salary</th>
                                <th style="padding:14px; text-align:left;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($calculations as $calc)
                                <tr style="border-bottom:1px solid #e2e8f0;">
                                    <td style="padding:14px;">{{ $calc->user_id }}</td>
                                    <td style="padding:14px;">{{ $calc->job_title }}</td>
                                    <td style="padding:14px;">{{ $calc->experience }}</td>
                                    <td style="padding:14px;">{{ $calc->location }}</td>
                                    <td style="padding:14px; font-weight:700; color:#16a34a;">£{{ $calc->calculated_salary }}</td>
                                    <td style="padding:14px;">
                                        <form action="{{ route('admin.calculation.delete', $calc->id) }}" method="POST" onsubmit="return confirm('Delete this calculation?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="
                                                background:#dc2626;
                                                color:white;
                                                border:none;
                                                padding:8px 12px;
                                                border-radius:10px;
                                                font-size:13px;
                                                font-weight:600;
                                                cursor:pointer;
                                            ">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding:14px; text-align:center; color:#64748b;">No salary calculations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <div class="site-footer">
        <p><strong>Daffodil International University</strong></p>
        <p>Prepared by <strong>Surjya Bhowmick</strong></p>
        <p>Project developed for the <strong>Web Design Course</strong></p>
    </div>
</x-app-layout>