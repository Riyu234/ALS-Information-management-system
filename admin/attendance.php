<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/navbar.php");



?>
<?php

try {
    // Database connection
    $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch attendance data grouped by full details
    $attendanceQuery = $conn->prepare("SELECT 
        CONCAT(learner.firstname, ' ', learner.middlename, ' ', learner.lastname) AS fullname,
        attendance.attendance_date,
        attendance.status
    FROM 
        attendance
    LEFT JOIN 
        learner ON attendance.learner_id = learner.learner_id
    ORDER BY 
        learner.firstname, learner.lastname, attendance.attendance_date DESC");
    $attendanceQuery->execute();
    $attendanceData = $attendanceQuery->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

    if (empty($attendanceData)) {
        throw new Exception("No attendance data available.");
    }

    // Calculate present count for each student
    $presentCounts = [];
    foreach ($attendanceData as $fullname => $records) {
        $count = 0;
        foreach ($records as $record) {
            // Ensure 'present' status is checked exactly, with trimming to avoid any extra spaces
            if (trim(strtolower($record['status'])) === 'present') {
                $count++;
            }
        }
        $presentCounts[$fullname] = ['count' => $count, 'lastname' => explode(' ', $fullname)[2]]; // Add last name for sorting
    }

    // Sort students by present count first, then by last name (if counts are the same)
    uasort($presentCounts, function($a, $b) {
        // First sort by present count in descending order
        if ($b['count'] !== $a['count']) {
            return $b['count'] - $a['count'];
        }
        // If counts are the same, sort by last name (ascending order)
        return strcmp($a['lastname'], $b['lastname']);
    });

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Ranks Based on Present Count</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #f9f9f9;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body style="">
	<div style="padding:20px;margin-top:100px">	
    <h1 style="text-align: center;">Student Ranks (Based on Present Count)</h1>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Full Name</th>
                <th>Present Count</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rank = 1;
            foreach ($presentCounts as $fullname => $data) {
                echo "<tr>";
                echo "<td>" . $rank++ . "</td>";
                echo "<td>" . htmlspecialchars($fullname) . "</td>";
                echo "<td>" . $data['count'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
</body>
</html>

<?php 

include("../includes/footer.php");

?>