<?php
// Database connection
require_once 'database.php';

// Fetch classes with fetchAll
$classes = $db->query('SELECT * FROM class')->fetchAll();

// Fetch assignments
function fetchAssignments($db, $class_id) {
    $stmt = $db->prepare('SELECT * FROM assignment WHERE class_id = ?');
    $stmt->execute([$class_id]);
    return $stmt->fetchAll();
}

// Calculate overall grade for a class
function calculateGrade($assignments) {
    $total_points_earned = 0;
    $total_points_possible = 0;

    foreach ($assignments as $assignment) {
        $total_points_earned += $assignment['points_earned'];
        $total_points_possible += $assignment['points_possible'];
    }

    return ($total_points_possible > 0) ? ($total_points_earned / $total_points_possible) * 100 : 0;
}
?>

<!-- Used resources learned in my Web Page Creation (INFO 1311) course to assist in parts here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Grades</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <h1>Grades</h1>
    <?php foreach ($classes as $class): ?>
        <?php $assignments = fetchAssignments($db, $class['class_id']); ?>
        <h2><?php echo htmlspecialchars($class['course_name']); ?> (<?php echo htmlspecialchars($class['department_code'] . ' ' . $class['course_number']); ?>)</h2>
        <table>
            <thead>
                <tr>
                    <th>Assignment Description</th>
                    <th>Points Earned</th>
                    <th>Points Possible</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assignments as $assignment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($assignment['task_name']); ?></td>
                        <td><?php echo htmlspecialchars($assignment['points_earned']); ?></td>
                        <td><?php echo htmlspecialchars($assignment['points_possible']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2"><strong>Overall Grade</strong></td>
                    <td><strong><?php echo round(calculateGrade($assignments), 2); ?>%</strong></td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
</body>
</html>