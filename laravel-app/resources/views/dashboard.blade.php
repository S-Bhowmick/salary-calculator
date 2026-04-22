<x-app-layout>
    <div style="min-height: 100vh; background: linear-gradient(135deg, #eef2ff, #f8fafc); padding: 30px 20px 60px;">
        <div style="max-width: 1100px; margin: 0 auto;">

            <div style="
                background: white;
                border-radius: 24px;
                padding: 30px;
                box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10);
                border: 1px solid #e2e8f0;
                margin-bottom: 25px;
            ">
                <h1 style="font-size: 34px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                    Dashboard
                </h1>
                <p style="color: #475569; font-size: 16px;">
                    Welcome back, {{ Auth::user()->name }}. Here you can see your salary calculation history.
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
                <div style="
                    background: white;
                    border-radius: 20px;
                    padding: 24px;
                    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
                    border: 1px solid #e2e8f0;
                ">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Total Calculations</p>
                    <h2 style="font-size: 30px; font-weight: 700; color: #0f172a;">
                        {{ $calculations->count() }}
                    </h2>
                </div>

                <div style="
                    background: white;
                    border-radius: 20px;
                    padding: 24px;
                    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
                    border: 1px solid #e2e8f0;
                ">
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Latest Salary</p>
                    <h2 style="font-size: 30px; font-weight: 700; color: #16a34a;">
                        @if($calculations->count() > 0)
                            £{{ $calculations->first()->calculated_salary }}
                        @else
                            £0
                        @endif
                    </h2>
                </div>
            </div>

            <div style="
                background: white;
                border-radius: 24px;
                padding: 30px;
                box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10);
                border: 1px solid #e2e8f0;
                margin-bottom: 25px;
            ">
                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                    flex-wrap: wrap;
                    gap: 12px;
                ">
                    <h2 style="font-size: 26px; font-weight: 700; color: #0f172a;">
                        Salary Trend Chart
                    </h2>

                    <a href="{{ url('/') }}" style="
                        text-decoration: none;
                        background: #2563eb;
                        color: white;
                        padding: 10px 16px;
                        border-radius: 12px;
                        font-size: 14px;
                        font-weight: 600;
                    ">
                        Back to Calculator
                    </a>
                </div>

                @if($calculations->count() > 0)
                    <canvas id="salaryChart" height="100"></canvas>
                @else
                    <p style="color:#64748b;">No chart data yet.</p>
                @endif
            </div>

            <div style="
                background: white;
                border-radius: 24px;
                padding: 30px;
                box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10);
                border: 1px solid #e2e8f0;
            ">
                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                    flex-wrap: wrap;
                    gap: 12px;
                ">
                    <h2 style="font-size: 26px; font-weight: 700; color: #0f172a;">
                        Salary History
                    </h2>
                </div>

                @if($calculations->count() > 0)
                    <div style="overflow-x: auto;">
                        <table style="
                            width: 100%;
                            border-collapse: collapse;
                            overflow: hidden;
                            border-radius: 16px;
                        ">
                            <thead>
                                <tr style="background: #0f172a; color: white;">
                                    <th style="padding: 14px; text-align: left;">Job Title</th>
                                    <th style="padding: 14px; text-align: left;">Experience</th>
                                    <th style="padding: 14px; text-align: left;">Location</th>
                                    <th style="padding: 14px; text-align: left;">Salary</th>
                                    <th style="padding: 14px; text-align: left;">Date</th>
                                    <th style="padding: 14px; text-align: left;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calculations as $calc)
                                    <tr style="border-bottom: 1px solid #e2e8f0;">
                                        <td style="padding: 14px;">{{ $calc->job_title }}</td>
                                        <td style="padding: 14px;">{{ $calc->experience }} years</td>
                                        <td style="padding: 14px;">{{ $calc->location }}</td>
                                        <td style="padding: 14px; font-weight: 700; color: #16a34a;">
                                            £{{ $calc->calculated_salary }}
                                        </td>
                                        <td style="padding: 14px;">
                                            {{ $calc->created_at->format('d M Y') }}
                                        </td>
                                        <td style="padding: 14px;">
                                            <form action="{{ route('calculation.delete', $calc->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="
                                                    background: #dc2626;
                                                    color: white;
                                                    border: none;
                                                    padding: 8px 12px;
                                                    border-radius: 10px;
                                                    font-size: 13px;
                                                    font-weight: 600;
                                                    cursor: pointer;
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
                @else
                    <div style="
                        background: #f8fafc;
                        border: 1px dashed #cbd5e1;
                        border-radius: 18px;
                        padding: 30px;
                        text-align: center;
                    ">
                        <p style="font-size: 18px; color: #475569; margin-bottom: 12px;">
                            No salary calculations found yet.
                        </p>
                        <a href="{{ url('/') }}" style="
                            text-decoration: none;
                            background: linear-gradient(135deg, #22c55e, #16a34a);
                            color: white;
                            padding: 12px 18px;
                            border-radius: 12px;
                            font-size: 14px;
                            font-weight: 600;
                            display: inline-block;
                        ">
                            Calculate Salary Now
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>

    @if($calculations->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('salaryChart').getContext('2d');

            const salaryChart = new Chart(ctx, {
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
                        borderColor: '#2563eb',
                        backgroundColor: '#2563eb',
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        </script>
    @endif
</x-app-layout>