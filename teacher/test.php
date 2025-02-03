<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit();
}

try {
    // Database connection
    $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch unique dates for table headings
    $dateQuery = $conn->prepare("SELECT DISTINCT attendance_date FROM attendance ORDER BY attendance_date DESC");
    $dateQuery->execute();
    $dates = $dateQuery->fetchAll(PDO::FETCH_COLUMN);

    // Fetch attendance data grouped by full details, ordered by lastname DESC
    $attendanceQuery = $conn->prepare("SELECT 
        CONCAT(learner.firstname, ' ', learner.middlename, ' ', learner.lastname) AS fullname,
        attendance.attendance_date,
        attendance.status
    FROM 
        attendance
    LEFT JOIN 
        learner ON attendance.learner_id = learner.learner_id
    ORDER BY 
        learner.lastname ASC, learner.firstname, attendance.attendance_date DESC");
    $attendanceQuery->execute();
    $attendanceData = $attendanceQuery->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

    if (empty($attendanceData)) {
        throw new Exception("No attendance data available.");
    }

    // Handle Excel file export
    if (isset($_POST['export_excel'])) {
        // Clear output buffer
        ob_clean();

        // Set headers for the Excel file download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=attendance_records.xls");
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");

        // Generate Excel content
        echo "<table border='1'>";
        echo "<tr><th>Full Name</th>";
        foreach ($dates as $date) {
            echo "<th>" . htmlspecialchars($date) . "</th>";
        }
        echo "</tr>";

        foreach ($attendanceData as $fullname => $records) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fullname) . "</td>";
            foreach ($dates as $date) {
                $status = '-';
                foreach ($records as $record) {
                    if ($record['attendance_date'] === $date) {
                        $status = $record['status'];
                        break;
                    }
                }
                echo "<td>" . htmlspecialchars($status) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        exit();
    }
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
    <title>Attendance Records</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #f9f9f9;
            position: relative;
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
        .sticky {
            position: sticky;
            z-index: 100;
        }
    </style>
</head>
<body style="overflow: scroll;">
    <h1 style="text-align: center;">Attendance Records</h1>
    <form method="post" style="text-align: center;">
        <button type="submit" name="export_excel" style="margin: 10px 0; padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
            Download as Excel
        </button>
    </form>
    <table>
        <thead>
            <tr>
                <th class="sticky" style="top: 0;left: 0;z-index: 2000;width: 250px">Full Name</th>
                <?php foreach ($dates as $date): ?>
                    <th class="sticky" style="top: 0"><?php echo htmlspecialchars($date); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($attendanceData as $fullname => $records): ?>
                <tr>
                    <td class="sticky" style="background-color: white;left: 0;z-index: 1000;"><?php echo htmlspecialchars($fullname); ?></td>
                    <?php foreach ($dates as $date): ?>
                        <td>
                            <?php
                            $status = '-';
                            foreach ($records as $record) {
                                if ($record['attendance_date'] === $date) {
                                    $status = $record['status'];
                                    break;
                                }
                            }
                            echo htmlspecialchars($status);
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
