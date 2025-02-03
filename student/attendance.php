<?php

session_start();

if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit();
}

include("../includes/header.php");
include("studentsidebar.php");
include("../includes/navbar.php");

// Ensure $conn is connected to the database

?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
    <style type="text/css">
        /* Styling (same as before) */
      

        .calendar-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 90px));
         	gap:15px 0px;
            margin: 20px;
        }

        .calendar {
            width: 100px;
            border: 2px solid #333;
            border-radius: 8px;
            text-align: center;
            background-color: #f4f4f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .calendar-header {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .calendar-body {
            font-size: 12px;
            color: #666;
        }

        .month {
            display: block;
            font-size: 12px;
            color: #007bff;
        }

        .day {
            font-size: 18px;
            color: #333;
        }

        .year {
            font-size: 12px;
            color: #888;
        }

        .present {
            background-color: #d4edda; /* Light green */
            border-color: #28a745; /* Green border */
        }

        .present .month, .present .day, .present .year {
            color: #155724; /* Dark green text */
        }

        .absent {
            background-color: #f8d7da; /* Light red */
            border-color: #dc3545; /* Red border */
        }

        .absent .month, .absent .day, .absent .year {
            color: #721c24; /* Dark red text */
        }
    </style>
</head>
<body>
    <div class="tab-content" id="family" style="margin-top: 100px; margin-left: 20px">
        <?php 
        $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

        $sqls = $conn->prepare("SELECT student_id from user where user_id=:ids");
        $sqls->bindParam(":ids", $_SESSION['userid']);
        $sqls->execute();

        $learner = $sqls->fetch(PDO::FETCH_ASSOC);

        $learner_id = $learner['student_id'];
        // Fetch attendance data
        $query = $conn->prepare("SELECT * FROM attendance WHERE learner_id = :id");
        $query->bindParam(":id", $learner_id);

        if ($query->execute()) {
            $attendances = $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Error fetching attendance data.";
            $attendances = [];
        }
        ?>
        <h5>Days of Present</h5>

        <div class="calendar-container present-days">
            <?php
             $present_count = 0;
             foreach ($attendances as $attendance): ?>
                <?php if ($attendance['status'] == 'Present'): ?>
                    <div class="calendar present">
                        <div class="calendar-header">
                            <span class="month"><?php echo date('F', strtotime($attendance['attendance_date'])); ?></span>
                            <span class="day"><?php echo date('d', strtotime($attendance['attendance_date'])); ?></span>
                        </div>
                        <div class="calendar-body">
                            <span class="year"><?php echo date('Y', strtotime($attendance['attendance_date'])); $present_count++; ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <p>Present Days Count: <?php echo $present_count; ?></p>

        <h5>Days of Absent</h5>

        <div class="calendar-container absent-days">
            <?php
            $absent_count = 0;
             foreach ($attendances as $attendance): ?>
                <?php if ($attendance['status'] == 'Absent'): ?>
                    <div class="calendar absent">
                        <div class="calendar-header">
                            <span class="month"><?php echo date('F', strtotime($attendance['attendance_date'])); ?></span>
                            <span class="day"><?php echo date('d', strtotime($attendance['attendance_date'])); ?></span>
                        </div>
                        <div class="calendar-body">
                            <span class="year"><?php echo date('Y', strtotime($attendance['attendance_date'])); $absent_count++;?></span>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <p>Absent Days Count: <?php echo $absent_count; ?></p>
    </div>
</body>
</html>

<?php include("../includes/footer.php"); ?>
