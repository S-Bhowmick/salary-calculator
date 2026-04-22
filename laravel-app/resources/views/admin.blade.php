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
                    Welcome Admin, {{ Auth::user()->name }}. Manage users and salary records here.
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
            </div>

            <div style="background: white; border-radius: 24px; padding: 30px; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10); border: 1px solid #e2e8f0; margin-bottom: 25px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr style="border-bottom:1px solid #e2e8f0;">
                                    <td style="padding:14px;">{{ $user->id }}</td>
                                    <td style="padding:14px;">{{ $user->name }}</td>
                                    <td style="padding:14px;">{{ $user->email }}</td>
                                    <td style="padding:14px;">
                                        {{ $user->is_admin ? 'Yes' : 'No' }}
                                    </td>
                                </tr>
                            @endforeach
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
                            @foreach($calculations as $calc)
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>