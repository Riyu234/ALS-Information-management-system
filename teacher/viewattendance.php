<?php
ob_start();
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit();
}

require '../../vendor/autoload.php';

include("../includes/header.php");
include("teachersidebar.php");
include("../includes/navbar.php");

try {
    // Database connection
    $conn = new PDO("mysql:dbname=system_als_database;host=localhost", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch unique dates for table headings
    $dateQuery = $conn->prepare("SELECT DISTINCT date FROM attendance ORDER BY date DESC");
    $dateQuery->execute();
    $dates = $dateQuery->fetchAll(PDO::FETCH_COLUMN);
    $attendanceQuery = $conn->prepare("SELECT 
        attendance.status,
        attendance.date,
        learner.firstname,
        learner.middlename,
        learner.lastname,
        
    FROM 
        attendance
    LEFT JOIN 
        learner ON attendance.learner_id = learner.learner_id 
        ORDER BY firstname, lastname, middlename, date DESC");
    $attendanceQuery->execute();
    $attendanceData = $attendanceQuery->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Helper function to generate status HTML
function generateStatusHTML($status)
{
    if ($status === 'Present') {
        return '<span class="status-check">✔</span>';
    } elseif ($status === 'Absent') {
        return '<span class="status-absent">✖</span>';
    }
    return '<span class="no-data">-</span>';
}

// Handle export to Excel
if (isset($_POST['export'])) {
    if (empty($attendanceData)) {
        echo "<script>alert('No attendance data available to export!');</script>";
    } else {
        ob_clean();
        
        // Headers for Excel file download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=attendance_records.xls");
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        
        // Start outputting the Excel content
        echo "<table border='1'>";
        echo "<tr><th>Full Name</th>";
        foreach ($dates as $date) {
            echo "<th>" . htmlspecialchars($date) . "</th>";
        }
        echo "</tr>";
        
        foreach ($attendanceData as $name => $records) {
            $lastname = htmlspecialchars($records[0]['lastname'] ?? '');
            $middlename = htmlspecialchars($records[0]['middlename'] ?? '');
            echo "<tr>";
            echo "<td>" . htmlspecialchars($name) . " $lastname $middlename</td>";
            foreach ($dates as $date) {
                $status = '-';
                foreach ($records as $record) {
                    if ($record['date'] === $date) {
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
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Records</title>
    <style>
        table {
            border-collapse: collapse;
            margin-left: 20px;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: black;
            color: white;
        }
        .status-check { color: green; font-weight: bold; }
        .status-absent { color: red; font-weight: bold; }
        .no-data { color: gray; }
        .date-column { width: 70px; }
        .name-column { text-align: left; }
        .tables { background-color: #fff; padding: 20px; margin: 80px 40px 20px 40px; }
        button { margin: 10px 0; }
        .pagination-controls {
            margin: 10px 0;
            text-align: center;
        }
        button {
            margin: 5px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            background-color: #f4f4f4;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="tables">
        <h1>Attendance Records</h1>
        <form method="post">
            <button type="submit" name="export">Export to Excel</button>
        </form>
        <a href="teacherattendance.php" style="position:absolute;right:10px;top:30px;">
            <button style="border:solid 1px gray;padding:5px;width:100px;background-color:#fff;">Back</button>
        </a>
        <div class="pagination-controls">
            <button onclick="prevColumns()">Previous</button>
            <button onclick="nextColumns()">Next</button>
        </div>
        <table id="dataTable">
            <thead>
                <tr>
                    <th class="name-column">Full Name</th>
                    <?php foreach ($dates as $index => $date): ?>
                        <th class="date-column" data-col-index="<?php echo $index; ?>">
                            <?php echo htmlspecialchars($date); ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendanceData as $name => $records): ?>
                    <?php 
                        $lastname = htmlspecialchars($records[0]['lastname'] ?? '');
                        $middlename = htmlspecialchars($records[0]['middlename'] ?? '');
                    ?>
                    <tr>
                        <td class="name-column"><?php echo htmlspecialchars($name) . " $lastname $middlename"; ?></td>
                        <?php foreach ($dates as $index => $date): ?>
                            <td class="date-column" data-col-index="<?php echo $index; ?>">
                                <?php
                                $status = '<span class="no-data">-</span>';
                                foreach ($records as $record) {
                                    if ($record['date'] === $date) {
                                        $status = generateStatusHTML($record['status']);
                                        break;
                                    }
                                }
                                echo $status;
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        let currentStartIndex = 0; // Starting column index for pagination
        const columnsPerPage = 15; // Maximum number of columns visible at once

        function updateTable() {
            const columns = document.querySelectorAll('[data-col-index]');
            const totalColumns = columns.length;

            // Hide all columns
            columns.forEach(col => {
                const colIndex = parseInt(col.getAttribute('data-col-index'));
                col.style.display = (colIndex >= currentStartIndex && colIndex < currentStartIndex + columnsPerPage)
                    ? ''
                    : 'none';
            });
        }

        function nextColumns() {
            const totalColumns = document.querySelectorAll('[data-col-index]').length;
            if (currentStartIndex + columnsPerPage < totalColumns) {
                currentStartIndex += columnsPerPage;
                updateTable();
            }
        }

        function prevColumns() {
            if (currentStartIndex - columnsPerPage >= 0) {
                currentStartIndex -= columnsPerPage;
                updateTable();
            }
        }

        // Initialize the table to show the first set of columns
        updateTable();
    </script>

    <?php include("../includes/footer.php"); ?>  
</body>
</html>
