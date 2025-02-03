<?php 

require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALS Enrollment Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;  
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            border-top: solid 10px green;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        fieldset {
            border: none;
            padding: 20px;
            display: none;
        }

        fieldset.active {
            display: block;
        }

        legend {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 15px;
            font-size: 16px;
        }

        input[type="submit"], .nav-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover, .nav-button:hover {
            background-color: #0056b3;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        @media (max-width: 600px) {
            .container {
                width: 95%;
            }
        }

        .intro {
            margin-top: 40px;
            height: 120px;
            width: 54%;
            background-color: green;
            margin-bottom: 20px;
            border-radius: 10px;
            text-align: left;
        }

        input[type="radio"] {
            transform: scale(1.5);
            margin-bottom: 15px;

        }
    </style>
</head>
<body>
    <div class="intro"><h1>ALS Enrollment Form</h1></div>
    <div class="container">
        <form action="#" method="POST">
    <!-- Page 1 -->
    <fieldset class="active">
        <legend>1. Learner's Personal Information</legend>
        
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>
        
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>
        
        <label for="middlename">Middle Name:</label>
        <input type="text" id="middlename" name="middlename" required>
        
        <label for="birthdate">Birthdate:</label>
        <input type="date" id="birthdate" name="birthdate" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
    </fieldset>

    <!-- Page 2 -->
    <fieldset>
        <legend>2. Learner's Personal Information</legend>
        
        <label>Belong In Indigenous People:</label><br>
        <label for="indigenous_yes">
            <input type="radio" id="indigenous_yes" name="indigenous_people" value="yes" required>
            Yes
        </label>
        <label for="indigenous_no">
            <input type="radio" id="indigenous_no" name="indigenous_people" value="no" required>
            No
        </label><br>

        <label>Member of 4ps:</label><br>
        <label for="4ps_yes">
            <input type="radio" id="4ps_yes" name="member_of_4ps" value="yes" required>
            Yes
        </label>
        <label for="4ps_no">
            <input type="radio" id="4ps_no" name="member_of_4ps" value="no" required>
            No
        </label><br>

        <label for="civil_status">Civil Status:</label>
        <select id="civil_status" name="civil_status" required>
            <option value="Single">Single</option>
            <option value="Separated">Separated</option>
            <option value="Married">Married</option>
            <option value="Solo Parent">Solo Parent</option>
            <option value="Widowed">Widowed</option>
        </select><br>

        <label for="religion">Religion:</label>
        <input type="text" id="religion" name="religion" required><br>

        <label for="mothertongue">Mother Tongue:</label>
        <input type="text" id="mothertongue" name="mothertongue" required>
    </fieldset>

    <!-- Page 3: Address Information -->
    <fieldset>
        <legend>3. Learner's Address Information</legend>
        
        <label for="street">Street:</label>
        <input type="text" id="street" name="street" required>
        
        <label for="barangay">Barangay:</label>
        <input type="text" id="barangay" name="barangay" required>
        
        <label for="municipality">Municipality:</label>
        <input type="text" id="municipality" name="municipality" required>
        
        <label for="province">Province:</label>
        <input type="text" id="province" name="province" required>

        <label for="zipcode">Zip Code:</label>
        <input type="text" id="zipcode" name="zipcode" required>
    </fieldset>

    <!-- Page 4: Parent Information -->
    <fieldset>
        <legend>4. Learner's Parent Information</legend>
        
        <label for="father">Father's Full Name:</label>
        <input type="text" id="father" name="father" required placeholder="Lname, Fname, Mname">

        <label for="foccupation">Father's Occupation:</label>
        <input type="text" id="foccupation" name="foccupation" required>

        <label for="mother">Mother's Full Name:</label>
        <input type="text" id="mother" name="mother" required placeholder="Lname, Fname, Mname">

        <label for="moccupation">Mother's Occupation:</label>
        <input type="text" id="moccupation" name="moccupation" required>
        
        <label for="guardian">Legal Guardian's Full Name:</label>
        <input type="text" id="guardian" name="guardian" required placeholder="Lname, Fname, Mname">
    </fieldset>

    <!-- Page 5: PWD Information and Grade Level -->
    <fieldset>
        <legend>5. Learner's PWD Information and Grade Level</legend>
        
        <label for="pwd">Is the Learner PWD?</label><br>
        <label for="pyes">
            <input type="radio" id="pyes" name="is_pwd" value="yes" required>
            Yes
        </label>
        <label for="pno">
            <input type="radio" id="pno" name="is_pwd" value="no" required>
            No
        </label><br>

        <label for="specifypwd">If Yes, Please Specify:</label>
        <input type="text" name="specifypwd"><br>

        <label for="grade_level">Last Grade Level Completed:</label>
        <!-- <select id="grade_level" name="grade_level" required>
            <option value="elementary">Elementary</option>
            <option value="grade_1">Grade 1</option>
            <option value="grade_2">Grade 2</option>
            <option value="grade_3">Grade 3</option>
            <option value="grade_4">Grade 4</option>
            <option value="grade_5">Grade 5</option>
            <option value="grade_6">Grade 6</option>
            <option value="grade_7">Grade 7</option>
            <option value="grade_8">Grade 8</option>
            <option value="grade_9">Grade 9</option>
            <option value="grade_10">Grade 10</option>
            <option value="grade_11">Grade 11</option>
        </select> -->
    </fieldset>

    


            <div class="button-container">
                <button type="button" class="nav-button" id="prevBtn">Previous</button>
                <button type="button" class="nav-button" id="nextBtn">Next</button>
                <input type="submit" value="Submit" id="submitBtn" style="display: none;" name="btn">
            </div>
        </form>
    </div>
    
    <?php

    $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

    
  

   if (isset($_POST['btn'])) {
    try {
        $conn->beginTransaction(); // Start transaction to ensure data integrity

        // Insert into enrollees table
        $sql = "INSERT INTO enrollees (
                lastname, firstname, middlename, birthdate, gender, contact_number,
                indigenous_people, member_of_4ps, civil_status, religion, mother_tongue, email, status
            ) VALUES (
                :lastname, :firstname, :middlename, :birthdate, :gender, :contact_number,
                :indigenous_people, :member_of_4ps, :civil_status, :religion, :mothertongue, :email, :status)";
        $stmt = $conn->prepare($sql);
        $notif = "new";

        $stmt->bindParam(':lastname', $_POST['lastname'], PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $_POST['firstname'], PDO::PARAM_STR);
        $stmt->bindParam(':middlename', $_POST['middlename'], PDO::PARAM_STR);
        $stmt->bindParam(':birthdate', $_POST['birthdate'], PDO::PARAM_STR);
        $stmt->bindParam(':gender', $_POST['gender'], PDO::PARAM_STR);
        $stmt->bindParam(':contact_number', $_POST['contact_number'], PDO::PARAM_STR);
        $stmt->bindParam(':indigenous_people', $_POST['indigenous_people'], PDO::PARAM_STR);
        $stmt->bindParam(':member_of_4ps', $_POST['member_of_4ps'], PDO::PARAM_STR);
        $stmt->bindParam(':civil_status', $_POST['civil_status'], PDO::PARAM_STR);
        $stmt->bindParam(':religion', $_POST['religion'], PDO::PARAM_STR);
        $stmt->bindParam(':mothertongue', $_POST['mothertongue'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindParam(':status', $notif, PDO::PARAM_STR);

        $stmt->execute();
        $enrollees_id = $conn->lastInsertId(); // Get the last inserted ID

        // Insert into enrollees_address table
        $address_sql = "INSERT INTO enrollees_address (
                            enrollees_id, street, barangay, municipality, province, zipcode
                        ) VALUES (
                            :enrollees_id, :street, :barangay, :municipality, :province, :zipcode)";
        $address_stmt = $conn->prepare($address_sql);
        $address_stmt->bindParam(':enrollees_id', $enrollees_id, PDO::PARAM_INT);
        $address_stmt->bindParam(':street', $_POST['street'], PDO::PARAM_STR);
        $address_stmt->bindParam(':barangay', $_POST['barangay'], PDO::PARAM_STR);
        $address_stmt->bindParam(':municipality', $_POST['municipality'], PDO::PARAM_STR);
        $address_stmt->bindParam(':province', $_POST['province'], PDO::PARAM_STR);
        $address_stmt->bindParam(':zipcode', $_POST['zipcode'], PDO::PARAM_STR);
        $address_stmt->execute();

        // Insert into enrollees_parent table
        $parent_sql = "INSERT INTO enrollees_parent (
                            enrollees_id, fathers_full_name, mothers_full_name, fathers_occupation, mothers_occupation, guardian
                        ) VALUES (
                            :enrollees_id, :fathers_full_name, :mothers_full_name, :fathers_occupation, :mothers_occupation, :guardian)";
        $parent_stmt = $conn->prepare($parent_sql);
        $parent_stmt->bindParam(':enrollees_id', $enrollees_id, PDO::PARAM_INT);
        $parent_stmt->bindParam(':fathers_full_name', $_POST['father'], PDO::PARAM_STR);
        $parent_stmt->bindParam(':mothers_full_name', $_POST['mother'], PDO::PARAM_STR);
        $parent_stmt->bindParam(':fathers_occupation', $_POST['foccupation'], PDO::PARAM_STR);
        $parent_stmt->bindParam(':mothers_occupation', $_POST['moccupation'], PDO::PARAM_STR);
        $parent_stmt->bindParam(':guardian', $_POST['guardian'], PDO::PARAM_STR);

        if ($parent_stmt->execute()) {
            $conn->commit(); // Commit the transaction

            // Send Email Notification using PHPMailer
            $email = $_POST['email'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];

            $mail = new PHPMailer(true);
            try {
                // SMTP server configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'riocagapevillasana04@gmail.com'; // Your Gmail address
                $mail->Password = 'tnng wysn hppt gndy'; // Your Gmail App password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Set up sender information
                $mail->setFrom('riocagapevillasana04@gmail.com', 'ALS Binalbagan');
                $mail->addAddress($email); // Send email to the student's email address
                $mail->Subject = "Enrollment Confirmation";
                $mail->Body = "Dear " . $firstname . " " . $lastname . ",\n\nYour enrollment has been successfully processed.\n\nThank you for enrolling with us!";

                $mail->send();
                echo "<script>alert('Enrollment and Email Sent Successfully'); window.location.href='enrollment.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Enrollment Successful, but Email Sending Failed: " . htmlspecialchars($mail->ErrorInfo) . "'); window.location.href='enrollment.php';</script>";
            }
        } else {
            throw new Exception("Failed to insert parent information");
        }
    } catch (Exception $e) {
        $conn->rollBack(); // Roll back the transaction in case of error
        echo "<script>alert('Send Failed: " . htmlspecialchars($e->getMessage()) . "');</script>";
    }
}
?>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        let currentFieldset = 0;
        const fieldsets = document.querySelectorAll('fieldset');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        function showFieldset(index) {
            // Hide all fieldsets
            fieldsets.forEach(fieldset => fieldset.classList.remove('active'));
            
            // Show the current fieldset
            fieldsets[index].classList.add('active');
            
            // Update button visibility
            prevBtn.style.display = index === 0 ? 'none' : 'inline-block';
            nextBtn.style.display = index === fieldsets.length - 1 ? 'none' : 'inline-block';
            submitBtn.style.display = index === fieldsets.length - 1 ? 'inline-block' : 'none';
        }

        function validateFieldset() {
            const inputs = fieldsets[currentFieldset].querySelectorAll('input[required], select[required]');
            let valid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.style.borderColor = 'red'; 
                    input.setCustomValidity('This field is required'); 
                } else {
                    input.style.borderColor = ''; 
                    input.setCustomValidity(''); 
                }
            });

            if (!valid) {
                alert('Please fill in all required fields.');
            }

            return valid;
        }

        nextBtn.addEventListener('click', () => {
            if (validateFieldset()) {
                if (currentFieldset < fieldsets.length - 1) {
                    showFieldset(++currentFieldset);
                }
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentFieldset > 0) {
                showFieldset(--currentFieldset);
            }
        });

        // Initialize the first fieldset and button visibility
        showFieldset(currentFieldset);
    });
</script>

</body>
</html>
