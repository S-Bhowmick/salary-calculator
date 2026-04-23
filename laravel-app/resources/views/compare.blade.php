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
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div>
                        <h1 style="font-size: 34px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                            Salary Comparison
                        </h1>
                        <p style="color: #475569; font-size: 16px;">
                            Compare your selected salary calculations side by side.
                        </p>
                    </div>

                    <a href="{{ route('dashboard') }}" style="
                        text-decoration:none;
                        background:#2563eb;
                        color:white;
                        padding:10px 16px;
                        border-radius:12px;
                        font-size:14px;
                        font-weight:600;
                    ">
                        Back to Dashboard
                    </a>
                </div>
            </div>

            <div style="
                background: white;
                border-radius: 24px;
                padding: 30px;
                box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10);
                border: 1px solid #e2e8f0;
            ">
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background:#0f172a; color:white;">
                                <th style="padding:14px; text-align:left;">Field</th>
                                @foreach($comparisons as $comparison)
                                    <th style="padding:14px; text-align:left;">Comparison {{ $loop->iteration }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom:1px solid #e2e8f0;">
                                <td style="padding:14px; font-weight:700;">Job Title</td>
                                @foreach($comparisons as $comparison)
                                    <td style="padding:14px;">{{ $comparison->job_title }}</td>
                                @endforeach
                            </tr>

                            <tr style="border-bottom:1px solid #e2e8f0;">
                                <td style="padding:14px; font-weight:700;">Experience</td>
                                @foreach($comparisons as $comparison)
                                    <td style="padding:14px;">{{ $comparison->experience }} years</td>
                                @endforeach
                            </tr>

                            <tr style="border-bottom:1px solid #e2e8f0;">
                                <td style="padding:14px; font-weight:700;">Location</td>
                                @foreach($comparisons as $comparison)
                                    <td style="padding:14px;">{{ $comparison->location }}</td>
                                @endforeach
                            </tr>

                            <tr style="border-bottom:1px solid #e2e8f0;">
                                <td style="padding:14px; font-weight:700;">Calculated Salary</td>
                                @foreach($comparisons as $comparison)
                                    <td style="padding:14px; color:#16a34a; font-weight:700;">£{{ $comparison->calculated_salary }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="padding:14px; font-weight:700;">Date</td>
                                @foreach($comparisons as $comparison)
                                    <td style="padding:14px;">{{ $comparison->created_at->format('d M Y') }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>