<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SalaryCalc</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar Section -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="dashboard.php" class="navbar-logo">SalaryCalc</a>
            <ul class="navbar-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Dashboard Content -->
    <div class="dashboard-container">
        <div class="dashboard-card">
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            <p>Your email: <?php echo $_SESSION['userEmail']; ?></p>
        </div>
        
        <!-- UK Salary Calculator -->
        <div class="calculator-container">
            <h3>UK Salary Calculator</h3>
            <form action="salary-calculator.php" method="POST">
                <label for="jobTitle">Job Title</label>
                <input type="text" id="jobTitle" name="jobTitle" placeholder="e.g., Software Developer" required>

                <label for="experience">Experience (Years)</label>
                <input type="number" id="experience" name="experience" required>

                <label for="location">Location</label>
                <select id="location" name="location" required>
                    <option value="London">London</option>
                    <option value="Manchester">Manchester</option>
                    <option value="Birmingham">Birmingham</option>
                </select>

                <button type="submit">Calculate Salary</button>
            </form>

            <!-- Display Previous Calculation -->
            <?php if (isset($_SESSION['userData'])): ?>
                <div class="previous-data">
                    <h3>Your Previous Calculation</h3>
                    <p><strong>Job Title:</strong> <?php echo htmlspecialchars($_SESSION['userData']['jobTitle']); ?></p>
                    <p><strong>Experience:</strong> <?php echo htmlspecialchars($_SESSION['userData']['experience']); ?> years</p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($_SESSION['userData']['location']); ?></p>
                    <p><strong>Salary Estimate:</strong> £<?php echo htmlspecialchars($_SESSION['userData']['salary']); ?></p>
                </div>
            <?php endif; ?>

            <!-- Error Handling -->
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>