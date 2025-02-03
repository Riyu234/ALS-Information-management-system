<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/navbar.php");



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Aesthetic Table</title>
  <style>
    .elephant-container {
      background: linear-gradient(135deg, #ffffff, #f3f4f6);
      border-radius: 12px;
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
      margin: 20px auto;
      width: 90%;
      max-width: 1200px;
      overflow-x: auto;
    }

    .zebra-table {
      width: 100%;
      border-collapse: collapse;
      min-width: 700px;
      font-size: 16px;
    }

    .lion-head {
      background: linear-gradient(135deg, #ff7e5f, #feb47b);
      color: #fff;
      text-align: left;
    }

    .lion-head th {
      padding: 14px 20px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .tiger-body tr {
      transition: background-color 0.3s ease;
    }

    .tiger-body tr:nth-child(odd) {
      background-color: #f9fafc;
    }

    .tiger-body tr:nth-child(even) {
      background-color: #f3f4f6;
    }

    .tiger-body tr:hover {
      background-color: #ffe3e3;
      transform: scale(1.02);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .giraffe-cell {
      padding: 12px 20px;
      color: #333;
      text-align: left;
    }

    .giraffe-cell:first-child {
      font-weight: bold;
      color: #555;
    }

    @media (max-width: 768px) {
      .giraffe-cell {
        padding: 10px 15px;
      }

      .lion-head th {
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      .giraffe-cell {
        padding: 8px 10px;
        font-size: 14px;
      }
    }

    .modal-overlay {
      position: fixed;
      top: 0;
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

    @media (max-width: 480px) {
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
    }
  </style>
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>
</head>
<body>
  <div style="margin-top: 100px;display: flex;align-items: center;">
    <h1 style="margin-left: 70px;background-color: transparent;margin-bottom: -10px"><i class="ri-chat-history-line"></i> Enrollment History</h1>
  <div class="search-container" style="margin-left: auto; margin-right: 70px">
    <input type="text" id="searchInput" class="search-input" placeholder="Search by name...">
</div>
  </div>
  
    
  <div class="elephant-container" >

    <div class="notification" style="margin-top: 20px; align-items: center; padding: 20px; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 10px">
    <form action="enrollment_history_print.php" method="POST">
    

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;width: 50px"></th>
            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;width: 210px">Name</th>
            <th style="text-align: left; border-bottom: 1px solid #ddd;">LastName</th>
            <th style="text-align: left; border-bottom: 1px solid #ddd;">MiddleName</th>
            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;text-align: center;">Status</th>
            <th style="text-align: left; border-bottom: 1px solid #ddd;width: 40px"></th>
        </tr>
    </thead>
    <tbody id="enrolleesTable">
        <?php 
            $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
            $sqll = $conn->prepare("SELECT * FROM enrollees WHERE is_enrolled = 'enrolled' ORDER BY enrollees_id DESC");

            if ($sqll->execute()) {
                $studentsFound = false;

                while ($students = $sqll->fetch(PDO::FETCH_ASSOC)) {
                    $studentsFound = true;
        ?>
                    <tr>
                        <td style="padding: 19px">
                            <?php echo "<input type='checkbox' name='students[]' value='" . $students['enrollees_id'] . "' class='studentCheckbox' >" ?>
                        </td>
                        <td style="padding: 9px;">
                            <a href="?id=<?php echo $students['enrollees_id'] ?>" 
                               style="<?php echo ($students['status'] == 'new') ? 'color: black;' : 'color: gray;'; ?>">
                                <?php echo ucfirst($students['firstname']); ?>
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
                            <a href="?id=<?php echo $students['enrollees_id']; ?>">View</a>
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
                    echo "<tr><td colspan='6' style='text-align: center;'>No enrollees</td></tr>";
                }

            } else {
                echo "Error executing query.";
            }
        ?>
    </tbody>
</table>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
    $stmt = $conn->prepare("
        SELECT 
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
        WHERE enrollees.enrollees_id = :id
    ");

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
        $genders = $row['gender'] . ".png"; // Replace with actual image logic
        $email = $row['email'];

        echo <<<HTML
        <div class="modal-overlay">
            <div class="student-profile-modal">
                <div class="profile-header" style="margin-bottom: 20px">
                    <h2><i class="ri-profile-fill" style="margin-right: 10px"></i>Student Profile</h2>
                </div>
                <hr>  
                <div class="profile-content">
                    <div class="profile-column picture-column">
                        <div class="profile-picture">
                            <img src="$genders" alt="Profile Picture">
                        </div>
                    </div>
                    <div class="profile-column personal-info-column">
                        <div class="profile-field"><strong>Last Name:</strong> <span>$lastname</span></div>
                        <div class="profile-field"><strong>First Name:</strong> <span>$firstname</span></div>
                        <div class="profile-field"><strong>Middle Name:</strong> <span>$middlename</span></div>
                        <div class="profile-field"><strong>Birthdate:</strong> <span>$birthdate</span></div>
                        <div class="profile-field"><strong>Gender:</strong> <span>$gender</span></div>
                        <div class="profile-field"><strong>Contact Number:</strong> <span>$contact_number</span></div>
                        <div class="profile-field"><strong>Indigenous People:</strong> <span>$indigenous_people</span></div>
                        <div class="profile-field"><strong>Member of 4Ps:</strong> <span>$member_of_4ps</span></div>
                        <div class="profile-field"><strong>Civil Status:</strong> <span>$civil_status</span></div>
                        <div class="profile-field"><strong>Religion:</strong> <span>$religion</span></div>
                       
                    </div>
                    <div class="profile-column address-family-column">
                        <div class="profile-field"><strong>Street:</strong> <span>$street</span></div>
                        <div class="profile-field"><strong>Barangay:</strong> <span>$barangay</span></div>
                        <div class="profile-field"><strong>Municipality:</strong> <span>$municipality</span></div>
                        <div class="profile-field"><strong>Province:</strong> <span>$province</span></div>
                        <div class="profile-field"><strong>Zipcode:</strong> <span>$zipcode</span></div>
                        <div class="profile-field"><strong>Father's Name:</strong> <span>$father</span></div>
                        <div class="profile-field"><strong>Father's Occupation:</strong> <span>$foccupation</span></div>
                        <div class="profile-field"><strong>Mother's Name:</strong> <span>$mother</span></div>
                        <div class="profile-field"><strong>Mother's Occupation:</strong> <span>$moccupation</span></div>
                        <div class="profile-field"><strong>Guardian:</strong> <span>$guardian</span></div>
                    </div>
                </div>
                <div style="display: flex; gap: 10px;"> 
                    <a href="enrollment_history.php">Close</a>
                    
                </div>
            </div>
        </div>
        HTML;
    } else {
        echo "<p>Student profile not found.</p>";
    }
}
?>




<script>
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
</script>

    <!-- Submit button to send selected students to the next PHP page -->
    

    <button type="submit" name="action" value="print">Print Selected</button>

</form>
  </div>
</body>
</html>

<?php 
include("../includes/footer.php");


?>