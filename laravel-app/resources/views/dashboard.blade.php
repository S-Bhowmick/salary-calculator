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

            @if($calculations->where('is_favorite', true)->count() > 0)
        <div style="
            background: white;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10);
            border: 1px solid #e2e8f0;
            margin-bottom: 25px;
            ">
            <h2 style="font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 16px;">
            Favorite Calculations
            </h2>

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:16px;">
            @foreach($calculations->where('is_favorite', true) as $favorite)
                <div style="
                    border: 1px solid #e2e8f0;
                    border-radius: 18px;
                    padding: 18px;
                    background: #f8fafc;
                ">
                    <p style="margin-bottom:8px;"><strong>Job:</strong> {{ $favorite->job_title }}</p>
                    <p style="margin-bottom:8px;"><strong>Location:</strong> {{ $favorite->location }}</p>
                    <p style="margin-bottom:8px;"><strong>Experience:</strong> {{ $favorite->experience }} years</p>
                    <p style="margin-bottom:8px; color:#16a34a; font-weight:700;"><strong>Salary:</strong> £{{ $favorite->calculated_salary }}</p>
                </div>
            @endforeach
            </div>
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
                    <a href="{{ route('report.download') }}" style="
                        text-decoration:none;
                        background:#16a34a;
                        color:white;
                        padding:10px 16px;
                        border-radius:12px;
                        font-size:14px;
                        font-weight:600;
                        display:inline-block;
                    ">
                        Download PDF Report
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
                <form action="{{ route('calculations.compare') }}" method="POST">
                    @csrf

                    <h2 style="font-size: 26px; font-weight: 700; color: #0f172a;">
                        Salary History
                    </h2>
                </div>
                
                <div style="margin-top:20px;">
                    <button type="submit" style="
                        background:#7c3aed;
                        color:white;
                        border:none;
                        padding:12px 18px;
                        border-radius:12px;
                        font-size:14px;
                        font-weight:600;
                        cursor:pointer;
                    ">
                        Compare Selected
                    </button>
                </div>
                </form>


                @if($calculations->count() > 0)
                    <div style="overflow-x: auto;">
                        <table style="
                            width: 100%;
                            border-collapse: collapse;
                            overflow: hidden;
                            border-radius: 16px;
                        ">
                            <thead>
                                <th style="padding: 14px; text-align: left;">Compare</th>
                                <th style="padding: 14px; text-align: left;">Favorite</th>
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
                                            <input type="checkbox" name="selected_calculations[]" value="{{ $calc->id }}">
                                        </td>

                                        <td style="padding: 14px;">
                                            <form action="{{ route('calculation.favorite', $calc->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" style="
                                                    background: {{ $calc->is_favorite ? '#f59e0b' : '#94a3b8' }};
                                                    color: white;
                                                    border: none;
                                                    padding: 8px 12px;
                                                    border-radius: 10px;
                                                    font-size: 13px;
                                                    font-weight: 600;
                                                    cursor: pointer;
                                                ">
                                                    {{ $calc->is_favorite ? '★ Favorite' : '☆ Mark' }}
                                                </button>
                                            </form>
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
    <div class="site-footer">
        <p><strong>Daffodil International University</strong></p>
        <p>Prepared by <strong>Surjya Bhowmick</strong></p>
        <p>Project developed for the <strong>Web Design Course</strong></p>
    </div>

</x-app-layout>