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

        // Calculate tax
        function calculateTax($salary) {
            $tax = 0;

            // Income tax bands for 2025-2026
            if ($salary <= 12570) {
                $tax = 0; // Personal allowance
            } elseif ($salary <= 50270) {
                $tax = ($salary - 12570) * 0.20; // Basic rate
            } elseif ($salary <= 150000) {
                $tax = (50270 - 12570) * 0.20 + ($salary - 50270) * 0.40; // Higher rate
            } else {
                $tax = (50270 - 12570) * 0.20 + (150000 - 50270) * 0.40 + ($salary - 150000) * 0.45; // Additional rate
            }

            // National Insurance (Class 1)
            $NI = 0;
            if ($salary > 12570) {
                if ($salary <= 50270) {
                    $NI = ($salary - 12570) * 0.12; // 12% between £12,570 and £50,270
                } else {
                    $NI = (50270 - 12570) * 0.12 + ($salary - 50270) * 0.02; // 2% over £50,270
                }
            }

            return $tax + $NI;
        }

        // Calculate net salary
        $totalSalary = ($minSalary + $maxSalary) / 2;
        $taxAndNI = calculateTax($totalSalary);
        $netSalary = $totalSalary - $taxAndNI;

        $salaryMessage = "Estimated Salary Range: £" . number_format($minSalary) . " - £" . number_format($maxSalary) . "<br>";
        $salaryMessage .= "Estimated Net Salary (after tax and NI): £" . number_format($netSalary);
    }

    // Redirect back to index.html with the salary message
    header("Location: index.html?salary=" . urlencode($salaryMessage));
    exit;
}
?>