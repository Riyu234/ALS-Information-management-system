<?php

if(!isset($_SESSION['userid'])){
	header("location:../login.php");
	exit();
}
include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/navbar.php");




 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Layout</title>
    <style>
        .weird-biodata-wrapper {
            width: 100%;
            max-width: 1100px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .weird-user-header {
            display: flex;
            align-items: center;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .weird-user-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            margin-bottom: -20px;
        }

        .weird-user-header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .weird-section {
            margin-bottom: 20px;
            padding: 10px;
        }

        .weird-section-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
            background-color: lightblue; /* Gray background for the section titles */
            padding: 8px;
        }

        .weird-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;

        }

        .weird-details div {
            font-size: 16px;
            color: #555;
        }

        .weird-details div label {
            font-weight: bold;
        }

        .weird-address-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .weird-address-details div {
            font-size: 16px;
            color: #555;
        }

        .weird-address-details div label {
            font-weight: bold;
        }
    </style>
</head>
<body>
	<h2 style="margin-top: 100px;margin-left:100px"><i class="ri-information-line"></i> Student Enrollment Details</h2>
    <div class="weird-biodata-wrapper">
        
        <div class="weird-user-header">
            <i class="ri-user-3-fill" style="font-size: 50px; margin-right: 20px"></i>
            <h4>Juan Carlos de la Cruz</h4>
        </div>

        <!-- Enrollees Details Section -->
        <div class="weird-section">
            <div class="weird-section-title">Student Details</div>
            <div class="weird-details">
                <div>
                    <label>Enrollment ID:</label>
                    <span>23</span>
                </div>
                <div>
                    <label>Birthdate:</label>
                    <span>Febuary 26, 2004</span>
                </div>
                <div>
                    <label>Gender</label>
                    <span>Male</span>
                </div>
                <div>
                    <label>Contact Number:</label>
                    <span>091983862364</span>
                </div>
                <div>
                    <label>Indigenous People:</label>
                    <span>No</span>
                </div>
                <div>
                    <label>Member of 4p's:</label>
                    <span>No</span>
                </div>
                <div>
                    <label>Civil Status:</label>
                    <span>Single</span>
                </div>
                <div>
                    <label>Religion:</label>
                    <span>Catholic</span>
                </div>
                <div>
                    <label>Mother Tongue:</label>
                    <span>Your Mother Tongue</span>
                </div>
                <div>
                    <label>Email</label>
                    <span>miming@gmail.com</span>
                </div>
                <div>
                    <label>Year Level Attended</label>
                    <span>High School</span>
                </div>
                <div>
                    <label>Last School Attended</label>
                    <span>Himamaylan National High School</span>
                </div>
            </div>
        </div>

        <!-- Student Parent Details Section -->
        <div class="weird-section">
            <div class="weird-section-title">Student Parent Details</div>
            <div class="weird-details">
                <div>
                    <label>Mother's Name:</label>
                    <span>Maria Elena de la Cruz</span>
                </div>
                <div>
                    <label>Father's Name:</label>
                    <span>Carlos Eduardo de la Cruz</span>
                </div>
                <div>
                    <label>Mother's Contact:</label>
                    <span>092838728423</span>
                </div>
                <div>
                    <label>Father's Contact:</label>
                    <span>092345322378</span>
                </div>
            </div>
        </div>

        <!-- Address Details Section -->
        <div class="weird-section">
            <div class="weird-section-title">Address Details</div>
            <div class="weird-address-details">
                <div>
                    <label>Street:</label>
                    <span>123 Main St.</span>
                </div>
                <div>
                    <label>Barangay:</label>
                    <span>Barangay 5</span>
                </div>
                <div>
                    <label>Municipality:</label>
                    <span>Himamaylan City</span>
                </div>
                <div>
                    <label>Province:</label>
                    <span>Negros Occidental</span>
                </div>
                <div>
                    <label>Zipcode:</label>
                    <span>6105</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>




 <?php

include("../includes/footer.php");
  ?>
