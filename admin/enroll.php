<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/navbar.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



?>






<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body >
	<div class="enrollment" style="margin: 100px auto; width: 90%;padding: 20px">
    <div style="display: flex;justify-content: space-between;">
      <h1 style="margin-top: "><i class="ri-group-fill"></i> Enrollees</h1>
    <h2></h2>
    <div class="search-container" style="margin-left: auto; margin-right: 70px">
    <input type="text" id="searchInput" class="search-input" placeholder="Search by name...">
</div>
    
      <form method="post">

<div style="display: flex; justify-content: flex-end; margin-right: 45px;gap:20px;">
  <input type="checkbox" id="selectAll" onclick="toggleSelectAll()" style="margin-top: -10px"><p style="">Select all</p>
  
  <a href="enrollment_history.php" style="border:none; background-color: white; padding: 10px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"><i class="ri-chat-history-fill"></i>History</a>
  
  
<button name="mark"style="border:none; background-color: white; padding: 10px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"><a href="studentcoe.php" style="color: black"><i class="ri-profile-fill"></i> Student COE</a></button>
<button name="mark"style="border:none; background-color: white; padding: 10px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"><i class="ri-mail-check-line"></i> Mark all as read</button></div>
</form>

    </div>

    <hr>
		
    
<div class="notification" style="margin-top: 20px; align-items: center; padding: 20px; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 10px; position: relative;">
    <form action="process_enrollees.php" method="POST">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;width: 50px"></th>
                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;width: 210px">Name</th>
                <th style=" text-align: left; border-bottom: 1px solid #ddd;">LastName</th>
                <th style=" text-align: left; border-bottom: 1px solid #ddd;">MiddleName</th>
                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;text-align: center;">Status</th>
                <th style=" text-align: left; border-bottom: 1px solid #ddd;width: 40px"></th>
            </tr>
        </thead>
        <tbody id="enrolleesTable">
           <?php 
    $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
    $sqll = $conn->prepare("SELECT * FROM enrollees WHERE is_enrolled != 'enrolled' ORDER BY enrollees_id DESC");

    if ($sqll->execute()) {
        $studentsFound = false; // Flag to track if there are any students

        while ($students = $sqll->fetch(PDO::FETCH_ASSOC)) {
            $studentsFound = true; // Set flag to true if a student is found
?>
            <tr>
                <td style="padding: 19px">
                    <?php echo "<input type='checkbox' name='students[]' value='" . $students['enrollees_id'] . "' class='studentCheckbox' >" ?>
                </td>
                <td style="padding: 9px;">
                    <a href="?id=<?php echo $students['enrollees_id'] ?>" 
                       style="<?php echo ($students['status'] == 'new') ? 'color: black;' : 'color: gray;'; ?>">
                        <?php echo  ucfirst($students['firstname']); ?>
                    </a>
                </td>
                <td>
                    <a href="?id=<?php echo $students['enrollees_id'] ?>" 
                       style="<?php echo ($students['status'] == 'new') ? 'color: black;' : 'color: gray;'; ?>">
                        <?php echo ucfirst($students['lastname']); ?>
                    </a>
                </td>
                <td>
                    <a href="?id=<?php echo $students['enrollees_id'] ?>" 
                       style="<?php echo ($students['status'] == 'new') ? 'color: black;' : 'color: gray;'; ?>">
                        <?php echo ucfirst($students['middlename']); ?>
                    </a>
                </td>
                <td style="text-align: center;" class="s">
                    <div style="display: inline-block; position: relative;">
                        <div style="padding: 5px 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 3px; font-size: 12px; font-weight: bold; text-align: center; display: inline-block;">
                            <a href="javascript:void(0);" style="color: white; text-decoration: none;" onclick="toggleDropdown(<?php echo $students['enrollees_id']; ?>)">Actions</a>
                        </div>
                        <div id="dropdown-<?php echo $students['enrollees_id']; ?>" class="dropdown-menu" style="display: none; position: absolute; background-color: #f9f9f9; min-width: 160px; z-index: 1; border-radius: 3px; box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);">
                            <a href="?id=<?php echo $students['enrollees_id']; ?>" style="display: block; padding: 8px 16px; text-decoration: none; color: black; font-size: 12px; font-weight: normal;">View</a>
                            <a href="enroll_solo.php?id=<?php echo $students['enrollees_id']; ?>" style="display: block; padding: 8px 16px; text-decoration: none; color: black; font-size: 12px; font-weight: normal;">Enroll</a>
                            <a href="?id=<?php echo $students['enrollees_id']; ?>" style="display: block; padding: 8px 16px; text-decoration: none; color: black; font-size: 12px; font-weight: normal;">Archive</a>
                        </div>
                    </div>
                </td>
                <td>
                    <?php if ($students['status'] == "new") { ?>
                        <div class="circle-container"><div class="active-circle red"></div></div>
                    <?php } else { ?>
                        <div class="circle-container"><div class="notactive-circle white"></div></div>
                    <?php } ?>
                </td>
            </tr>
<?php 
        }

        if (!$studentsFound) {
            echo "<tr><td colspan='6' style='text-align: center;margin-top:100px;'>No enrollees</td></tr>"; // Display message when no students found
        }

    } else {
        echo "Error executing query.";
    }

    if(isset($_GET['selected'])){
        echo "<script>alert('select students')</script>";
    }
?>

    

        </tbody>
    </table>

    <!-- Submit button to send selected students to the next PHP page -->
    <div style="position: sticky; bottom: 0; left: 0; background-color: white; padding: 10px 0;  text-align: left;">
            <button type="submit" name="action" value="enroll" style="background-color: #4CAF50; color: white; border: none; padding: 5px 10px; margin: 0 5px; border-radius: 5px; font-size: 14px; cursor: pointer;">Enroll Selected</button>
            <button type="submit" name="action" value="print" style="background-color: #2196F3; color: white; border: none; padding: 5px 10px; margin: 0 5px; border-radius: 5px; font-size: 14px; cursor: pointer;">Print Selected</button>
        </div>

</form>




   <?php
// Fetch the learner data if an ID is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

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
        $email = $row['email']; // Added email field

        // Check if enroll button is clicked
        if (isset($_POST['enroll'])) {

            

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
        // Insert into enrollees table
                    $sql = "INSERT INTO learner (
                            lastname, firstname, middlename, birth_date, gender, contact_number,
                            indigenous_people, member_of_4ps, civil_status, religion, email
                        ) VALUES (
                            :lastname, :firstname, :middlename, :birthdate, :gender, :contact_number,
                            :indigenous_people, :member_of_4ps, :civil_status, :religion, :email)";
                    $stmt = $conns->prepare($sql);
                    

                    $stmt->bindParam(':lastname',$lastname , PDO::PARAM_STR);
                    $stmt->bindParam(':firstname',$firstname , PDO::PARAM_STR);
                    $stmt->bindParam(':middlename',$middlename , PDO::PARAM_STR);
                    $stmt->bindParam(':birthdate',$birthdate , PDO::PARAM_STR);
                    $stmt->bindParam(':gender',$gender , PDO::PARAM_STR);
                    $stmt->bindParam(':contact_number',$contact_number , PDO::PARAM_STR);
                    $stmt->bindParam(':indigenous_people',$indigenous_people , PDO::PARAM_STR);
                    $stmt->bindParam(':member_of_4ps',$member_of_4ps , PDO::PARAM_STR);
                    $stmt->bindParam(':civil_status',$civil_status , PDO::PARAM_STR);
                    $stmt->bindParam(':religion',$religion , PDO::PARAM_STR);
                    $stmt->bindParam(':email',$email , PDO::PARAM_STR);
                 

                    $stmt->execute();
                    $learner_id = $conns->lastInsertId(); // Get the last inserted ID

                    // Insert into enrollees_address table
                    $address_sql = "INSERT INTO learners_address (
                                        learners_id, street, barangay, municipality, province, zipcode
                                    ) VALUES (
                                        :learner_id, :street, :barangay, :municipality, :province, :zipcode)";
                    $address_stmt = $conn->prepare($address_sql);
                    $address_stmt->bindParam(':learner_id', $learner_id, PDO::PARAM_INT);
                    $address_stmt->bindParam(':street', $street, PDO::PARAM_STR);
                    $address_stmt->bindParam(':barangay', $barangay, PDO::PARAM_STR);
                    $address_stmt->bindParam(':municipality', $municipality, PDO::PARAM_STR);
                    $address_stmt->bindParam(':province', $province, PDO::PARAM_STR);
                    $address_stmt->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
                    $address_stmt->execute();

                    // Insert into enrollees_parent table
                    $parent_sql = "INSERT INTO learner_parents (
                                        learner_id, learners_father, learners_mother, fathers_occupation, mothers_occupation, learner_guardian
                                    ) VALUES (
                                        :learner_id, :learners_father, :learners_mother, :fathers_occupation, :mothers_occupation, :guardian)";
                    $parent_stmt = $conns->prepare($parent_sql);
                    $parent_stmt->bindParam(':learner_id', $learner_id, PDO::PARAM_INT);
                    $parent_stmt->bindParam(':learners_father', $father, PDO::PARAM_STR);
                    $parent_stmt->bindParam(':learners_mother', $mother, PDO::PARAM_STR);
                    $parent_stmt->bindParam(':fathers_occupation', $foccupation, PDO::PARAM_STR);
                    $parent_stmt->bindParam(':mothers_occupation', $moccupation, PDO::PARAM_STR);
                    $parent_stmt->bindParam(':guardian', $guardian, PDO::PARAM_STR);
                    $parent_stmt->execute();


                    $enrolled = "INSERT INTO enrolled (enrollees_id) VALUES (:enrollees_id)";
                    $prepareenrolled = $conns->prepare($enrolled);
                    $prepareenrolled->bindParam(':enrollees_id', $id, PDO::PARAM_INT);
                    $prepareenrolled->execute();


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

                    // Prepare the query
                    

                   
                } else {
                    echo "<script>alert('Failed to send email');</script>";
                }
            } catch (Exception $e) {
                echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "');</script>";
            }
        }
?>

<div class="modal-overlay">
  <div class="student-profile-modal">
    <div class="profile-header" style="margin-bottom: 20px">
      <h2><i class="ri-profile-fill" style="margin-right: 10px"></i>Student Profile</h2>
    </div>
    <hr>  
    <div class="profile-content">
      <!-- Column 1: Picture -->
      <div class="profile-column picture-column">
        <div class="profile-picture">
          <img src="<?php echo $genders?>">
        </div>
      </div>

      <!-- Column 2: Personal Info -->
      <div class="profile-column personal-info-column">
        <div class="profile-field roaring-lion">
          <strong>Last Name:</strong> <span class="striped-zebra"><?php echo htmlspecialchars($lastname); ?></span>
        </div>
        <div class="profile-field leaping-frog">
          <strong>First Name:</strong> <span class="bouncing-kangaroo"><?php echo htmlspecialchars($firstname); ?></span>
        </div>
        <div class="profile-field fluttering-butterfly">
          <strong>Middle Name:</strong> <span class="dancing-peacock"><?php echo htmlspecialchars($middlename); ?></span>
        </div>
        <div class="profile-field galloping-horse">
          <strong>Birthdate:</strong> <span class="soaring-eagle"><?php echo htmlspecialchars($birthdate); ?></span>
        </div>
        <div class="profile-field howling-wolf">
          <strong>Gender:</strong> <span class="slithering-snake"><?php echo htmlspecialchars($gender); ?></span>
        </div>
        <div class="profile-field hopping-rabbit">
          <strong>Contact Number:</strong> <span class="buzzing-bee"><?php echo htmlspecialchars($contact_number); ?></span>
        </div>
        <div class="profile-field waddling-penguin">
          <strong>Indigenous People:</strong> <span class="gliding-swan"><?php echo htmlspecialchars($indigenous_people); ?></span>
        </div>
        <div class="profile-field prowling-tiger">
          <strong>Member of 4Ps:</strong> <span class="hunting-hawk"><?php echo htmlspecialchars($member_of_4ps); ?></span>
        </div>
        <div class="profile-field lurking-jaguar">
          <strong>Street:</strong> <span class="crawling-crab"><?php echo htmlspecialchars($street); ?></span>
        </div>
      </div>

      <!-- Column 3: Address and Family -->
      <div class="profile-column address-family-column">
        <div class="profile-field swimming-shark">
          <strong>Barangay:</strong> <span class="diving-turtle"><?php echo htmlspecialchars($barangay); ?></span>
        </div>
        <div class="profile-field soaring-condor">
          <strong>Municipality:</strong> <span class="gliding-albatross"><?php echo htmlspecialchars($municipality); ?></span>
        </div>
        <div class="profile-field nesting-sparrow">
          <strong>Province:</strong> <span class="chirping-robin"><?php echo htmlspecialchars($province); ?></span>
        </div>
        <div class="profile-field burrowing-fox">
          <strong>Zipcode:</strong> <span class="digging-mole"><?php echo htmlspecialchars($zipcode); ?></span>
        </div>
        <div class="profile-field stalking-leopard">
          <strong>Father's Full Name:</strong> <span class="roaring-panther"><?php echo htmlspecialchars($father); ?></span>
        </div>
        <div class="profile-field crouching-puma">
          <strong>Father's Occupation:</strong> <span class="pouncing-lynx"><?php echo htmlspecialchars($foccupation); ?></span>
        </div>
        <div class="profile-field climbing-monkey">
          <strong>Mother's Full Name:</strong> <span class="swinging-orangutan"><?php echo htmlspecialchars($mother); ?></span>
        </div>
        <div class="profile-field galloping-antelope">
          <strong>Mother's Occupation:</strong> <span class="prancing-gazelle"><?php echo htmlspecialchars($moccupation); ?></span>
        </div>
        <div class="profile-field barking-dog">
          <strong>Guardian:</strong> <span class="wagging-puppy"><?php echo htmlspecialchars($guardian); ?></span>
        </div>
      </div>
    </div>
    <div style="display: flex; gap:10px"> 
      <a href="enroll.php"><button class="close-button" >Close</button></a>
      <form method="POST">
        <button type="submit" name="enroll" class="close-button" style="background-color: green">Enroll</button>
      </form>
    </div>
  </div>
</div>
<?php
    }
}
?>

</div>


	</div>

	<style type="text/css">

    .s button{
      padding: 3px;
      width: 60px;
    }

	}
    .notifications {
      max-width: 600px;
      margin: 0 auto;
      
    }
    .notifications {
      background-color: #fff;
      border: 1px solid #ddd;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      padding: 20px;
      margin-bottom: 10px;
      font-size:18px;
      width: 97%;

     
    
    }
    .notification-title {
      font-weight: bold;
      margin-bottom: 5px;
      display: flex;
      align-items: center;
      
    }
    .notification-details {
      color: #555;
    }

    .circle-container{
    	
    }
    .modal-overlay {
      position: fixed;
      top: 0;
      margin-top: 40px;
      left: 130px;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .student-profile-modal {
      background: #fff;
      padding: 20px;
      width: 90%;
      max-width: 900px;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
      font-family: Arial, sans-serif;
    }

    .profile-header h2 {
      text-align: left;
      color: #333;
      font-size: 24px;
      margin-bottom: 20px;
      font-weight: bold;
      margin-left: 20px;
    }

    .profile-content {
      display: flex;
      gap: 20px;
    }

    .profile-column {
      flex: 1;
    }

    .picture-column .profile-picture {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }

    .profile-picture img {
      height: 190px;
      object-fit: cover;
    }

    .profile-field {
      margin: 15px 0;
    }

    .profile-field strong {
      color: #555;
    }

    .profile-field span {
      color: #222;
      font-weight: bold;
    }

    .close-button {
      margin: 20px auto;
      width: 145px;
      padding: 10px 20px;
      background: crimson;
      color:lightgray;
      font-weight: 600;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .close-button:hover {
      background: darkred;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .student-profile-modal {
        padding: 15px;
      }

      .profile-content {
        flex-direction: column;
        gap: 10px;
      }

      .profile-column {
        flex: unset;
      }

      .profile-header h2 {
        font-size: 20px;
      }

      .profile-picture img {
        height: 150px;
        width: 150px;
      }
    }

    @media (max-width: 500px) {
      .student-profile-modal {
        width: 95%;
        padding: 10px;
      }

      .profile-header h2 {
        font-size: 18px;
      }

      .profile-field strong {
        font-size: 14px;
      }

      .profile-field span {
        font-size: 14px;
      }

      .close-button {
        font-size: 14px;
        padding: 8px 16px;
      }
      .modal-overlay{
        left: -10px;
        overflow-y: auto;
      }
    }
  </style>
</head>


<?php

if(isset($_POST['mark'])){
  $old = "old";
$query = "UPDATE enrollees SET status = :old";
$stmt = $conn->prepare($query);
$stmt->bindParam(":old", $old);
$stmt->execute();
}?>

<style type="">
	
.circle-container {
      display: flex;
     
    }

    .active-circle {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      box-shadow: 0 0 0 6px rgba(0, 0, 0, 0.1), 
                  0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .notactive-circle {
      width: 13px;
      height: 13px;
      border-radius: 50%;
   
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .active-circle.red {
      background-color: #F44336; /* Red */
      box-shadow: 0 0 0 6px #F8B8B4, 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .active-circle.white {
      background-color: white; /* Red */
      
    }

    

</style>

<script>
        // Toggle select/unselect all checkboxes
        function toggleSelectAll() {
            var isChecked = document.getElementById('selectAll').checked;
            var checkboxes = document.querySelectorAll('.studentCheckbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        }

        document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#enrolleesTable tr');

        rows.forEach(row => {
            const name = row.cells[1]?.textContent.toLowerCase();
            const lastName = row.cells[2]?.textContent.toLowerCase();
            const middleName = row.cells[3]?.textContent.toLowerCase();

            if (name?.includes(filter) || lastName?.includes(filter) || middleName?.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Toggle the visibility of the dropdown menu for a specific student
    function toggleDropdown(studentId) {
        const dropdown = document.getElementById('dropdown-' + studentId);
        
        // Hide all dropdowns first
        const allDropdowns = document.querySelectorAll('.dropdown-menu');
        allDropdowns.forEach(function(dropdownMenu) {
            dropdownMenu.style.display = 'none';
        });

        // Toggle the selected student's dropdown
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    // Close the dropdown menu if clicked outside of it
    window.addEventListener('click', function(event) {
        const allDropdowns = document.querySelectorAll('.dropdown-menu');
        allDropdowns.forEach(function(dropdown) {
            if (!event.target.closest('.dropdown-menu') && !event.target.closest('a')) {
                dropdown.style.display = 'none';
            }
        });
    });

    </script>

   
	
			
</body>
</html>

<?php 
include("../includes/footer.php");


?>