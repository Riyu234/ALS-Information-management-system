<?php

// Include the Composer autoload file (only once)
require '../../vendor/autoload.php'; 
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../vendor/phpmailer/phpmailer/src/Exception.php'; // Make sure this path is correct

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form has been submitted and if 'enroll' action is triggered
if (isset($_POST['action']) && $_POST['action'] === 'enroll' && isset($_POST['students']) && !empty($_POST['students'])) {
    // Collect selected student IDs
    $selected_students = $_POST['students'];
    $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

    // Assuming the database connection ($conn) is already established
    foreach ($selected_students as $id) {
        // Prepare the SQL to fetch the student details
        $stmt = $conn->prepare("SELECT 
            enrollees.lastname,
            enrollees.firstname,
            enrollees.middlename,
            enrollees.birthdate,
            enrollees.gender,
            enrollees.contact_number,
            enrollees.indigenous_people,
            enrollees.member_of_4ps,
            enrollees.civil_status,
            enrollees.religion,
            enrollees.mother_tongue,
            enrollees_address.street,
            enrollees_address.barangay,  
            enrollees_address.municipality,
            enrollees_address.province,   
            enrollees_address.zipcode, 
            enrollees_parent.fathers_full_name,
            enrollees_parent.mothers_full_name, 
            enrollees_parent.fathers_occupation, 
            enrollees_parent.mothers_occupation, 
            enrollees_parent.guardian,
            enrollees.email
        FROM 
            enrollees
        LEFT JOIN 
            enrollees_address ON enrollees.enrollees_id = enrollees_address.enrollees_id
        LEFT JOIN 
            enrollees_parent ON enrollees.enrollees_id = enrollees_parent.enrollees_id
        WHERE enrollees.enrollees_id = :id");

        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Collect student details
            $lastname = $row['lastname'];
            $firstname = $row['firstname'];
            $middlename = $row['middlename'];
            $birthdate = $row['birthdate'];
            $gender = $row['gender'];
            $contact_number = $row['contact_number'];
            $indigenous_people = $row['indigenous_people'];
            $member_of_4ps = $row['member_of_4ps'];
            $civil_status = $row['civil_status'];
            $religion = $row['religion'];
            $mothertongue = $row['mother_tongue'];
            $street = $row['street'];
            $barangay = $row['barangay'];
            $municipality = $row['municipality'];
            $province = $row['province'];
            $zipcode = $row['zipcode'];
            $father = $row['fathers_full_name'];
            $foccupation = $row['fathers_occupation'];
            $mother = $row['mothers_full_name'];
            $moccupation = $row['mothers_occupation'];
            $guardian = $row['guardian'];
            $email = $row['email'];

            // Send confirmation email to the student
            $mail = new PHPMailer(true);
            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'riocagapevillasana04@gmail.com';
                $mail->Password = 'tnng wysn hppt gndy';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Set sender information
                $mail->setFrom('riocagapevillasana04@gmail.com', 'ALS Binalbagan');
                $mail->addAddress($email);
                $mail->Subject = "Enrollment Confirmation";
                $mail->Body = "Dear " . $firstname . " " . $lastname . ",\n\nYour enrollment has been successfully processed.\n\nThank you for enrolling with us!";

                // Send email
                if ($mail->send()) {
                    echo "<script>alert('Enrollment successful for " . htmlspecialchars($firstname) . " " . htmlspecialchars($lastname) . "');</script>";

                    // Insert the student data into the learners table
                    $conns = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
                    $sql = "INSERT INTO learner (
                        lastname, firstname, middlename, birth_date, gender, contact_number,
                        indigenous_people, member_of_4ps, civil_status, religion, email
                    ) VALUES (
                        :lastname, :firstname, :middlename, :birthdate, :gender, :contact_number,
                        :indigenous_people, :member_of_4ps, :civil_status, :religion, :email)";

                    $stmt = $conns->prepare($sql);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':middlename', $middlename);
                    $stmt->bindParam(':birthdate', $birthdate);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':contact_number', $contact_number);
                    $stmt->bindParam(':indigenous_people', $indigenous_people);
                    $stmt->bindParam(':member_of_4ps', $member_of_4ps);
                    $stmt->bindParam(':civil_status', $civil_status);
                    $stmt->bindParam(':religion', $religion);
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                    $learner_id = $conns->lastInsertId(); // Get the last inserted ID

                    // Insert address and parent data into respective tables
                    // Insert into learners_address
                    $address_sql = "INSERT INTO learners_address (
                                        learners_id, street, barangay, municipality, province, zipcode
                                    ) VALUES (
                                        :learner_id, :street, :barangay, :municipality, :province, :zipcode)";
                    $address_stmt = $conns->prepare($address_sql);
                    $address_stmt->bindParam(':learner_id', $learner_id);
                    $address_stmt->bindParam(':street', $street);
                    $address_stmt->bindParam(':barangay', $barangay);
                    $address_stmt->bindParam(':municipality', $municipality);
                    $address_stmt->bindParam(':province', $province);
                    $address_stmt->bindParam(':zipcode', $zipcode);
                    $address_stmt->execute();

                    // Insert into learner_parents
                    $parent_sql = "INSERT INTO learner_parents (
                                        learner_id, learners_father, learners_mother, fathers_occupation, mothers_occupation, learner_guardian
                                    ) VALUES (
                                        :learner_id, :learners_father, :learners_mother, :fathers_occupation, :mothers_occupation, :guardian)";
                    $parent_stmt = $conns->prepare($parent_sql);
                    $parent_stmt->bindParam(':learner_id', $learner_id);
                    $parent_stmt->bindParam(':learners_father', $father);
                    $parent_stmt->bindParam(':learners_mother', $mother);
                    $parent_stmt->bindParam(':fathers_occupation', $foccupation);
                    $parent_stmt->bindParam(':mothers_occupation', $moccupation);
                    $parent_stmt->bindParam(':guardian', $guardian);
                    $parent_stmt->execute();

                    // Mark the student as enrolled
                    $enrolled = "enrolled";
                    $sqlss = "UPDATE enrollees SET is_enrolled = :status WHERE enrollees_id = :id";
                    $stmtssss = $conn->prepare($sqlss);
                    $stmtssss->bindParam(':status', $enrolled);
                    $stmtssss->bindParam(':id', $id);
                    $stmtssss->execute();

                    header("location:enroll.php");
                } else {
                    echo "<script>alert('Failed to send email for " . htmlspecialchars($firstname) . " " . htmlspecialchars($lastname) . "');</script>";
                }
            } catch (Exception $e) {
                echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "');</script>";
            }
        }
    }
} else {
    
    

}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'print') {
        $students = $_POST['students'] ?? [];

        if (empty($students)) {
            echo "Please select at least one student.<br>";
            exit;
        } else {
            // Connect to the database to fetch student details
            try {
                $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Prepare and execute query to fetch students' details
                $in  = str_repeat('?,', count($students) - 1) . '?';
                $sql = "SELECT enrollees_id, firstname, lastname FROM enrollees WHERE enrollees_id IN ($in)";
                $stmt = $conn->prepare($sql);
                $stmt->execute($students);
                $studentDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<script>window.print()</script>";

                // If no students found, exit
                if (!$studentDetails) {
                    echo "No students found.<br>";
                    exit;
                }

                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Printable Student List</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }
                        .print-container {
                            width: 100%;
                            max-width: 800px;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #ddd;
                            border-radius: 10px;
                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                            background-color: #f9f9f9;
                        }
                        h2 {
                            text-align: center;
                            margin-bottom: 10px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 20px 0;
                        }
                        table th, table td {
                            border: 1px solid #ddd;
                            text-align: left;
                            padding: 8px;
                        }
                        table th {
                            background-color: #f4f4f4;
                        }
                        .print-button {
                            display: inline-block;
                            margin-top: 20px;
                            padding: 10px 20px;
                            background-color: #007bff;
                            color: #fff;
                            text-decoration: none;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                        }
                        .print-button:hover {
                            background-color: #0056b3;
                        }

                        /* Print-Only Styling */
                        @media print {
                            body * {
                                visibility: hidden; /* Hide everything */
                            }
                            .print-container, .print-container * {
                                visibility: visible; /* Only show print-container */
                            }
                            .print-container {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                margin: 0;
                                padding: 0;
                                box-shadow: none; /* Remove shadow in print */
                                border: none; /* Remove border in print */
                            }
                            .print-button {
                                display: none; /* Hide print button in print view */
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="print-container">
                        <h2>Assigned Students</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($studentDetails as $student): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($student['enrollees_id']) ?></td>
                                        <td><?= htmlspecialchars(ucfirst($student['firstname'])) . ' ' . htmlspecialchars(ucfirst($student['lastname'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button class="print-button" onclick="window.print()">Print List</button>
                    </div>
                </body>
                </html>
                <?php
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
?>
<script>
        // Listen for beforeprint event (when print dialog is about to open)
        

        // Listen for afterprint event (when print dialog is closed)
        window.onafterprint = function () {
            window.location.href = "enroll.php";
            
        };
    </script>