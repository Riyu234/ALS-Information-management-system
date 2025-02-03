<?php
$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
$learner_id = $_GET['id']; // Get learner ID from the URL

if (isset($learner_id)) {
    echo "<script>window.print()</script>";
}

// Fetch the learner's details from the database
$sqll = $conn->prepare("SELECT * FROM learner WHERE learner_id = :id");
$sqll->bindParam(':id', $learner_id);
$sqll->execute();
$students = $sqll->fetch(PDO::FETCH_ASSOC);

$firstname = htmlspecialchars($students['firstname']);
$lastname = htmlspecialchars($students['lastname']);
$middlename = htmlspecialchars($students['middlename']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Enrollment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .container {
            width: 280mm;
            height: 320mm;
            margin: 0 auto;
            padding: 20mm;
            box-sizing: border-box;
            display: none; /* Hide the container by default */
        }
        @media print {
            .container {
                display: block; /* Show the container when printing */
            }
        }
        .header {
            text-align: center;
        }
        .header img {
            width: 170px;
            height: 170px;
        }
        .header .text {
            font-size: 22px;
        }
        .header .school-name {
            font-size: 25px;
            font-weight: bold;
        }
        .header .als {
            font-size: 20px;
            font-weight: bold;
        }
        .date {
            margin-top: 20px;
            font-size: 22px;
            text-align: left;
        }
        .content {
            margin-top: 40px;
            font-size: 22px;
            text-align: justify;
        }
        .content .student-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .footer {
            margin-top: 60px;
            text-align: left;
        }
        .footer .signature {
            font-size: 22px;
            font-weight: bold;
            text-decoration: underline;
        }
        .footer .name {
            font-size: 22px;
            font-weight: bold;
        }
        .footer .designation {
            font-size: 22px;
        }
    </style>
    <script>
        // Event listener for when printing starts or ends
        window.onbeforeprint = function() {
            // Print dialog is opening
        };

        window.onafterprint = function() {
            // After printing or canceling, go back to the previous page
            window.location.href = "studentcoe.php";  // Redirect back to the page where you set the ID
        };
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <img src="../assets/img/deped-logo.png" alt="DepEd Logo">
                <div>
                    <div class="text">Department of Education</div>
                    <div class="school-name">LA FILIPINA NATIONAL HIGH SCHOOL</div>
                    <div class="als">ALTERNATIVE LEARNING SYSTEM</div>
                    <div class="text">La Filipina National High School Learning Center</div>
                </div>
                <img src="../assets/img/orig-logo.png" alt="School Logo">
            </div>
        </div>
        <br><br><br><br>
        <div class="date">
            <?php echo date('F d, Y'); // Display the current date ?>
        </div>
        <br><br><br>
        <div class="content">
            <p>To Whom It May Concern;</p>
            
            <p>This is to certify that <span class="student-name">
                <?php echo "$firstname $middlename $lastname"; ?>
            </span> 
            is enrolled in the Alternative Learning System of the La Filipina National High School Learning 
            Center, La Filipina, Tagum City, for the School Year 2016-2017.</p>
            <p>This certification is issued for 4Ps APPLICATION and PROOF OF ENROLMENT.</p>
        </div>
        <div class="footer">
            <div><p style="font-size: 22px">Signed:</p></div>
            <br><br><br><br>
            <div class="signature">__________________________</div>
            <div class="name">MR. EUGENE S. ABULOC</div>
            <div class="designation">School ALS Coordinator</div>
        </div>
    </div>
</body>
</html>
