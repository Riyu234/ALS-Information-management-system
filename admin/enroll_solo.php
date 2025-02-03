<?php
// Include your database connection



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

// Check if the ID is received
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the learner data if the ID is set
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
        // Extract the learner data
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
        $genders = $row['gender'] . ".png";
        $email = $row['email'];

        // Include PHPMailer and send the enrollment confirmation email
        require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
        require '../../vendor/phpmailer/phpmailer/src/Exception.php';

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

            // Send the email
            if ($mail->send()) {
                echo "<script>alert('Enrollment successful and email sent to " . htmlspecialchars($email) . "');</script>";
                
                // Start transaction to ensure data integrity
                $conns = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

                // Insert into learner table
                $sql = "INSERT INTO learner (lastname, firstname, middlename, birth_date, gender, contact_number, indigenous_people, member_of_4ps, civil_status, religion, email) 
                        VALUES (:lastname, :firstname, :middlename, :birthdate, :gender, :contact_number, :indigenous_people, :member_of_4ps, :civil_status, :religion, :email)";
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

                // Get the learner ID after insertion
                $learner_id = $conns->lastInsertId();

                // Insert into address table
                $address_sql = "INSERT INTO learners_address (learners_id, street, barangay, municipality, province, zipcode) 
                                VALUES (:learner_id, :street, :barangay, :municipality, :province, :zipcode)";
                $address_stmt = $conns->prepare($address_sql);
                $address_stmt->bindParam(':learner_id', $learner_id);
                $address_stmt->bindParam(':street', $street);
                $address_stmt->bindParam(':barangay', $barangay);
                $address_stmt->bindParam(':municipality', $municipality);
                $address_stmt->bindParam(':province', $province);
                $address_stmt->bindParam(':zipcode', $zipcode);
                $address_stmt->execute();

                // Insert into parent table
                $parent_sql = "INSERT INTO learner_parents (learner_id, learners_father, learners_mother, fathers_occupation, mothers_occupation, learner_guardian) 
                               VALUES (:learner_id, :learners_father, :learners_mother, :fathers_occupation, :mothers_occupation, :guardian)";
                $parent_stmt = $conns->prepare($parent_sql);
                $parent_stmt->bindParam(':learner_id', $learner_id);
                $parent_stmt->bindParam(':learners_father', $father);
                $parent_stmt->bindParam(':learners_mother', $mother);
                $parent_stmt->bindParam(':fathers_occupation', $foccupation);
                $parent_stmt->bindParam(':mothers_occupation', $moccupation);
                $parent_stmt->bindParam(':guardian', $guardian);
                $parent_stmt->execute();

                // Update the enrollment status
                $enrols = "enrolled";

                    $sqlss = "UPDATE enrollees 
                            SET is_enrolled = :status 
                            WHERE enrollees_id = :id";

                    $stmtssss = $conn->prepare($sqlss);

                    $stmtssss->bindParam(':status', $enrols, PDO::PARAM_STR);
                    $stmtssss->bindParam(':id', $id, PDO::PARAM_INT);

                    

                    if($stmtssss->execute()){
                      unset($id);
                      echo "<script type='text/javascript'>
        window.location.href = 'enroll.php';
    </script>";
                      exit();
                      
                    }

                // Redirect to the enrollment page after successful enrollment
                echo "<script type='text/javascript'>window.location.href = 'enroll.php';</script>";
            } else {
                echo "<script>alert('Failed to send email');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "');</script>";
        }
    } else {
        echo "<script>alert('Learner not found');</script>";
    }
}
?>
