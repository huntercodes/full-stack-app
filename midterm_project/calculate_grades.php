<?php
$totalEarned = 0;
$totalPossible = 0;
$grades = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    for ($i = 1; $i <= 6; $i++) {
        $earned = isset($_POST["earned$i"]) ? floatval($_POST["earned$i"]) : 0;
        $possible = isset($_POST["possible$i"]) ? floatval($_POST["possible$i"]) : 0;
        if ($possible > 0) {
            $grades[$i] = ($earned / $possible) * 100;
        } else {
            $grades[$i] = 0;
        }
        $totalEarned += $earned;
        $totalPossible += $possible;
    }

    $overallGrade = ($totalPossible > 0) ? ($totalEarned / $totalPossible) * 100 : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Results</title>
</head>
<body>
<h1>Grade Results</h1>
<?php if (!empty($grades)): ?>
    <h2>Individual Grades</h2>
    <ul>
        <?php foreach ($grades as $index => $grade): ?>
            <li>Grade <?= $index ?>: <?= number_format($grade, 2) ?>%</li>
        <?php endforeach; ?>
    </ul>
    <h2>Overall Grade</h2>
    <p><?= number_format($overallGrade, 2) ?>%</p>
<?php else: ?>
    <p>No grades calculated. Please enter grades in the form.</p>
<?php endif; ?>
</body>
</html>