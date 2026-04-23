<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Denied</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="page-shell">
        <div class="panel" style="max-width:700px; margin:80px auto;">
            <div class="premium-heading">
                <h1>403</h1>
                <p>You do not have permission to access this page.</p>
            </div>
            <div class="top-actions" style="margin-top:20px;">
                <a href="{{ route('home') }}" class="top-action-btn">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>