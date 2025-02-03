

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
    <?php 
     $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
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
        enrollees_parent.guardian 
        
    FROM 
        enrollees
    LEFT JOIN 
        enrollees_address ON enrollees.enrollees_id = enrollees_address.enrollees_id
    LEFT JOIN 
        enrollees_parent ON enrollees.enrollees_id = enrollees_parent.enrollees_id

    where enrollees.enrollees_id = :id
        ");
        
        
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
          
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
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
            
            
        
    }
    ?>
    <div class="intro"><h1>ALS Enrollment Form</h1></div>
    <div class="container">
    <form action="#" method="POST">
            <!-- Page 1 -->
            <fieldset class="active">
                <legend>1. Learner's Personal Information</legend>
                
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
                
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>
                
                <label for="middlename">Middle Name:</label>
                <input type="text" id="middlename" name="middlename" value="<?php echo htmlspecialchars($middlename); ?>" required>
                
                <label for="birthdate">Birthdate:</label>
                <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male" <?php if ($gender == 'male') echo 'checked'; ?>>Male</option>
                    <option value="female" <?php if ($gender == 'female') echo 'checked'; ?>>Female</option>
                </select>

                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>" required>
            </fieldset>

            <!-- Page 2 -->
            <fieldset>
                <legend>2. Learner's Personal Information</legend>
                
                <label>Belong In Indigenous People:</label><br>
                <label for="indigenous_yes">
                    <input type="radio" id="indigenous_yes" name="indigenous_people" value="yes" <?php if ($indigenous_people == 'yes') echo 'checked'; ?> >
                    Yes
                </label>
                <label for="indigenous_no">
                    <input type="radio" id="indigenous_no" name="indigenous_people" value="no" <?php if ($indigenous_people == 'no') echo 'checked'; ?> >
                    No
                </label><br>

                <label>Member of 4ps:</label><br>
                <label for="4ps_yes">
                    <input type="radio" id="4ps_yes" name="member_of_4ps" value="yes" <?php if ($member_of_4ps == 'yes') echo 'checked'; ?> >
                    Yes
                </label>
                <label for="4ps_no">
                    <input type="radio" id="4ps_no" name="member_of_4ps" value="no" <?php if ($member_of_4ps == 'no') echo 'checked'; ?> >
                    No
                </label><br>

                <label for="civil_status">Civil Status:</label>
                <select id="civil_status" name="civil_status" required>
                    <option value="Single" <?php if ($civil_status == 'Single') echo 'selected'; ?>>Single</option>
                    <option value="Separated" <?php if ($civil_status == 'Separated') echo 'selected'; ?>>Separated</option>
                    <option value="Married" <?php if ($civil_status == 'Married') echo 'selected'; ?>>Married</option>
                    <option value="Solo Parent" <?php if ($civil_status == 'Solo Parent') echo 'selected'; ?>>Solo Parent</option>
                    <option value="Widowed" <?php if ($civil_status == 'Widowed') echo 'selected'; ?>>Widowed</option>
                </select><br>

                <label for="religion">Religion:</label>
                <input type="text" id="religion" name="religion" value="<?php echo htmlspecialchars($religion); ?>" required><br>

                <label for="mothertongue">Mother Tongue:</label>
                <input type="text" id="mothertongue" name="mothertongue" value="<?php echo htmlspecialchars($mothertongue); ?>" required>
            </fieldset>

            <!-- Page 3: Address Information -->
            <fieldset>
                <legend>3. Learner's Address Information</legend>
                
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($street); ?>" required>
                
                <label for="barangay">Barangay:</label>
                <input type="text" id="barangay" name="barangay" value="<?php echo htmlspecialchars($barangay); ?>" required>
                
                <label for="municipality">Municipality:</label>
                <input type="text" id="municipality" name="municipality" value="<?php echo htmlspecialchars($municipality); ?>" required>
                
                <label for="province">Province:</label>
                <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($province); ?>" required>

                <label for="zipcode">Zip Code:</label>
                <input type="text" id="zipcode" name="zipcode" value="<?php echo htmlspecialchars($zipcode); ?>" required>
            </fieldset>

            <!-- Page 4: Parent Information -->
            <fieldset>
                <legend>4. Learner's Parent Information</legend>
                
                <label for="father">Father's Full Name:</label>
                <input type="text" id="father" name="father" value="<?php echo htmlspecialchars($father); ?>" required placeholder="Lname, Fname, Mname">

                <label for="foccupation">Father's Occupation:</label>
                <input type="text" id="foccupation" name="foccupation" value="<?php echo htmlspecialchars($foccupation); ?>" required>

                <label for="mother">Mother's Full Name:</label>
                <input type="text" id="mother" name="mother" value="<?php echo htmlspecialchars($mother); ?>" required placeholder="Lname, Fname, Mname">

                <label for="moccupation">Mother's Occupation:</label>
                <input type="text" id="moccupation" name="moccupation" value="<?php echo htmlspecialchars($moccupation); ?>" required>
                
                <label for="guardian">Legal Guardian's Full Name:</label>
                <input type="text" id="guardian" name="guardian" value="<?php echo htmlspecialchars($guardian); ?>" required placeholder="Lname, Fname, Mname">
            </fieldset>

            <!-- Page 5: PWD Information and Grade Level -->
            <fieldset>
                <legend>5. Learner's PWD Information and Grade Level</legend>
                
                <label for="pwd">Is the Learner PWD?</label><br>
                <label for="pyes">
                    <input type="radio" id="pyes" name="is_pwd" value="yes" <?php if ($is_pwd == 'yes') echo "checked"; ?> >
                    Yes
                </label>
                <label for="pno">
                    <input type="radio" id="pno" name="is_pwd" value="no" <?php if ($is_pwd == 'no') echo "checked"; ?> >
                    No
                </label><br>

                <label for="specifypwd">If Yes, Please Specify:</label>
                <input type="text" name="specifypwd" value="<?php echo htmlspecialchars($specifypwd); ?>"><br>

                <label for="grade_level">Last Grade Level Completed:</label>
                <select id="grade_level" name="grade_level" required>
                    <option value="elementary" <?php if ($grade_level == 'elementary') echo 'selected'; ?>>Elementary</option>
                    <option value="grade_1" <?php if ($grade_level == 'grade_1') echo 'selected'; ?>>Grade 1</option>
                    <option value="grade_2" <?php if ($grade_level == 'grade_2') echo 'selected'; ?>>Grade 2</option>
                    <option value="grade_3" <?php if ($grade_level == 'grade_3') echo 'selected'; ?>>Grade 3</option>
                    <option value="grade_4" <?php if ($grade_level == 'grade_4') echo 'selected'; ?>>Grade 4</option>
                    <option value="grade_5" <?php if ($grade_level == 'grade_5') echo 'selected'; ?>>Grade 5</option>
                    <option value="grade_6" <?php if ($grade_level == 'grade_6') echo 'selected'; ?>>Grade 6</option>
                    <option value="grade_7" <?php if ($grade_level == 'grade_7') echo 'selected'; ?>>Grade 7</option>
                    <option value="grade_8" <?php if ($grade_level == 'grade_8') echo 'selected'; ?>>Grade 8</option>
                    <option value="grade_9" <?php if ($grade_level == 'grade_9') echo 'selected'; ?>>Grade 9</option>
                    <option value="grade_10" <?php if ($grade_level == 'grade_10') echo 'selected'; ?>>Grade 10</option>
                    <option value="grade_11" <?php if ($grade_level == 'grade_11') echo 'selected'; ?>>Grade 11</option>
                </select>
            </fieldset>

            <!-- Submit button -->
            <div class="button-container">
                <button type="button" class="nav-button" id="prevBtn">Previous</button>
                <button type="button" class="nav-button" id="nextBtn">Next</button>
                
                <button  id="submitBtn" style="display: none;" name="mark"style="border:none;cursor:pointer;  padding: 10px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">Mark as read</button>
            </div>
        </form>
    </div>
    
    <?php
?>
<?php

if(isset($_POST['mark'])){
  $old = "old";
$query = "UPDATE enrollees_info SET notify = :old where id=$id";
$stmt = $conn->prepare($query);
$stmt->bindParam(":old", $old);
$stmt->execute();
header("location:enroll.php");
}?>

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
