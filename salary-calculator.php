<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobTitle = $_POST['jobTitle'];
    $experience = $_POST['experience'];
    $location = $_POST['location'];

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

        $salaryMessage = "Estimated Salary Range: £" . $minSalary . " - £" . $maxSalary;
    }

    // Redirect back to index.html with the salary message
    header("Location: index.html?salary=" . urlencode($salaryMessage));
    exit;
}
?>