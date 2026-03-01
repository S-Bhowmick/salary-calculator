<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if job title, experience, and location are provided
    if (empty($_POST['jobTitle']) || empty($_POST['experience']) || empty($_POST['location'])) {
        $errorMessage = "Please fill in all fields.";
        header("Location: index.html?error=" . urlencode($errorMessage));
        exit;
    }

    // Sanitize and validate inputs
    $jobTitle = htmlspecialchars($_POST['jobTitle']);
    $experience = intval($_POST['experience']);
    $location = $_POST['location'];

    if ($experience <= 0 || !is_numeric($experience)) {
        $errorMessage = "Experience must be a positive number.";
        header("Location: index.html?error=" . urlencode($errorMessage));
        exit;
    }

    // Example salary ranges (can be updated with real data or database)
    $salaries = [
        'London' => [
            'Software Developer' => [35000, 60000],
            'Data Analyst' => [30000, 50000],
            'Project Manager' => [40000, 65000]
        ],
        'Manchester' => [
            'Software Developer' => [30000, 50000],
            'Data Analyst' => [25000, 45000],
            'Project Manager' => [35000, 55000]
        ],
        'Birmingham' => [
            'Software Developer' => [32000, 55000],
            'Data Analyst' => [27000, 47000],
            'Project Manager' => [37000, 58000]
        ]
    ];

    // Default message in case of missing salary data
    $salaryMessage = "Salary data unavailable for selected job title and location.";

    // Calculate the salary based on job title, experience, and location
    if (isset($salaries[$location][$jobTitle])) {
        // Calculate the salary based on experience level (this is just a simple linear model for demonstration)
        $baseSalary = $salaries[$location][$jobTitle];
        $minSalary = $baseSalary[0] + ($experience * 1000); // Add £1000 per year of experience
        $maxSalary = $baseSalary[1] + ($experience * 1500); // Add £1500 per year of experience

        // Calculate tax and NI (previously added code)

        $totalSalary = ($minSalary + $maxSalary) / 2;
        $taxAndNI = calculateTax($totalSalary);
        $netSalary = $totalSalary - $taxAndNI;

        $salaryMessage = "Estimated Salary Range: £" . number_format($minSalary) . " - £" . number_format($maxSalary) . "<br>";
        $salaryMessage .= "Estimated Net Salary (after tax and NI): £" . number_format($netSalary);
    } else {
        $errorMessage = "Salary data not available for the selected job title and location.";
        header("Location: index.html?error=" . urlencode($errorMessage));
        exit;
    }

    // Redirect back to index.html with the salary message or error message
    if (isset($salaryMessage)) {
        header("Location: index.html?salary=" . urlencode($salaryMessage));
    } else {
        header("Location: index.html?error=" . urlencode($errorMessage));
    }
    exit;
}
?>