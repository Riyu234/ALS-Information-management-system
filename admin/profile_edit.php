<?php




include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/navbar.php");


?>



<?php 
     $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
     if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        $stmtss = $conn->prepare("SELECT 
            learner.lastname,
            learner.firstname,
            learner.middlename,
            learner.birth_date,
            learner.email,
            learner.gender,
            learner.contact_number,
            learner.civil_status,
            learner.religion,
            learner.guardian,
            learner.status,
            learners_address.barangay,  
            learners_address.municipality,
            learners_address.province,   
            learners_address.zipcode,
            learner_parents.learners_father,
            learner_parents.learners_mother,
            learner_parents.fathers_occupation,
            learner_parents.mothers_occupation,
            learner_parents.learner_guardian
            
        FROM 
            learner
        LEFT JOIN 
            learners_address ON learner.learner_id = learners_address.learners_id
        LEFT JOIN
            learner_parents ON learner.learner_id = learner_parents.learner_id
        WHERE
            learner.learner_id = :id
        ");
        
        echo $id;
        $stmtss->bindParam(":id", $id);
        $stmtss->execute();
    
        $row = $stmtss->fetch(PDO::FETCH_ASSOC);
    
        $lastname = $row['lastname'];
        $firstname = $row['firstname'];
        $middlename = $row['middlename'];
        $birthdate = $row['birth_date'];
        $gender = $row['gender'];
        $email = $row['email'];
        $status = $row['status'];
        $contact_number = $row['contact_number'];
        $civil_status = $row['civil_status'];
        $religion = $row['religion'];
        $guardian = $row['guardian'];
        $barangay = $row['barangay'];
        $municipality = $row['municipality'];
        $province = $row['province'];
        $zipcode = $row['zipcode'];
        $learners_father = $row['learners_father'];
        $learners_mother = $row['learners_mother'];
        $fathers_occupation = $row['fathers_occupation'];
        $mothers_occupation = $row['mothers_occupation'];
        $learner_guardian = $row['learner_guardian'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Information</title>
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>
    <style>
         {
            
            
            background-color: #f9f9f9;
        }
        .containerss {
            
            max-width: 1250px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            
            border-radius: 8px;
        }
        .headerss {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .headerss h1 {
            margin: 0;
        }
        .profiless {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profiless img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .profiless .info {
            font-size: 1.2em;
        }
        .tabsss {
            display: flex;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }
        .tabsss button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1em;
            border-bottom: 3px solid transparent;
        }
        .tabsss button.active {
            border-bottom: 3px solid #007bff;
            font-weight: bold;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .info-grid div {
            padding: 5px 0;
        }
        .info-grid div span {
            font-weight: bold;
        }

        .calendar-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
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

    /* Styling for present days */
    .present {
        background-color: #d4edda; /* Light green */
        border-color: #28a745; /* Green border */
    }

    .present .month, .present .day, .present .year {
        color: #155724; /* Dark green text */
    }

    /* Styling for absent days */
    .absent {
        background-color: #f8d7da; /* Light red */
        border-color: #dc3545; /* Red border */
    }

    .absent .month, .absent .day, .absent .year {
        color: #721c24; /* Dark red text */
    }
    .alien-dropdown-container {
            position: relative;
            display: inline-block;
        }

        .extraterrestrial-menu {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 150px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .extraterrestrial-menu a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .extraterrestrial-menu a:hover {
            background-color: #f1f1f1;
        }

        .alien-toggle-button {
            padding: 5px 10px;
            background-color:rgb(76, 112, 137);
            color: white;
            border: none;
            cursor: pointer;
        }

        .alien-toggle-button:hover {
            background-color:rgb(57, 88, 99);
        }
    
    </style>
</head>
<body style="background-color:#fff;font-family: Arial, sans-serif;">
    <div class="containerss" style="margin-top:80px;">
        <div class="headerss">
        
            <h1 style="margin-bottom:40px"> <a href="student.php"><i class="ri-arrow-left-line" style="margin-right:20px"></i></a>Learner Information</h1>
            <button>Print</button>
        </div>
        <div class="profiless">
            <img src="<?php 
                if($gender == 'Male') { echo '../assets/img/boy.png'; }
                elseif($gender == 'Female') { echo '../assets/img/girl.png'; }
            ?>" alt="Profile Picture">
            <div class="infoss">
                <h3><strong><?php echo $lastname . ' ' . $firstname . ' ' . $middlename; ?></strong></h3>
                <p>ID: 012-0755-1857 
                <div class="alien-dropdown-container">
                <button class="alien-toggle-button">Action <i class="ri-arrow-down-s-fill"></i></button>
                <div class="extraterrestrial-menu">
                    <a href="#">Mark as Inactive</a>
                    <a href="#">Archive</a>
                    <a href="#">Edit</a>
                </div>
            </div>
            </div>
        </div>

        <div class="tabsss">
            <button class="tab-button active" data-tab="individual">Individual</button>
            <button class="tab-button" data-tab="module">Module</button>
            <button class="tab-button" data-tab="family">Attendance</button>
            
            <button class="tab-button" data-tab="facilitator">Facilitator</button>
        </div>

        <div class="tab-content active" id="individual">
        <form method="POST" action="process_update.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"> <!-- Hidden input for learner ID -->
        <div class="info-grid">
    <!-- Learner Name -->
    <div>
        <label>Learner Name:</label>
        <input type="text" name="firstname" value="<?php echo htmlspecialchars(ucwords($firstname)); ?>" placeholder="First Name">
    </div>
    <div>
        <label>Learner Last Name:</label>               
        <input type="text" name="lastname" value="<?php echo htmlspecialchars(ucwords($lastname)); ?>" placeholder="Last Name">
    </div>
    <div>
        <label>Learner Middle Name:</label>
        <input type="text" name="middlename" value="<?php echo htmlspecialchars(ucwords($middlename)); ?>" placeholder="Middle Name">
    </div>
    
    <!-- Preferred Name -->
    
    <!-- Birth Details -->
    <div>
        <label>Birth Country:</label>
        <input type="text" name="birth_country" value="Philippines" readonly>
    </div>
    <div>
        <label>Birth Date:</label>
        <input type="date" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>">
    </div>
    
    <!-- Gender -->
    <div>
        <label>Gender:</label>
        <select name="gender">
            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
        </select>
    </div>
    
    <!-- Contact Details -->
    <div>
        <label>Contact Number:</label>
        <input type="text" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>">
    </div>
    <div>
        <label>Mailing Address (Email):</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
    </div>
    
    <!-- Residential Address -->
    <div>
        <label>Barangay: </label>
        <input type="text" name="barangay" value="<?php echo htmlspecialchars(ucwords($barangay)); ?>" placeholder="Barangay">
    </div>
    
    <!-- Additional Address -->
    <div>
        <label>Municipality: </label>
        <input type="text" name="municipality" value="<?php echo htmlspecialchars(ucwords($municipality)); ?>" placeholder="Municipality">
    </div>

    <div>
        <label>Zip Code: </label>
        <input type="text" name="zipcode" value="<?php echo htmlspecialchars(ucwords($zipcode)); ?>" placeholder="Zip Code">
    </div>
    <div>
        <label>Province: </label>
        <input type="text" name="province" value="<?php echo htmlspecialchars(ucwords($province)); ?>" placeholder="Province">
    </div>
    
    <!-- Civil Status -->
    <div>
        <label>Civil Status:</label>
        <select name="civil_status">
            <option value="Single" <?php echo ($civil_status == 'Single') ? 'selected' : ''; ?>>Single</option>
            <option value="Married" <?php echo ($civil_status == 'Married') ? 'selected' : ''; ?>>Married</option>
            <option value="Divorced" <?php echo ($civil_status == 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
            <option value="Widowed" <?php echo ($civil_status == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
        </select>
    </div>

    <!-- Father's Information -->
    <div>
        <label>Father's Name:</label>
        <input type="text" name="learners_father" value="<?php echo htmlspecialchars(ucwords($learners_father)); ?>" placeholder="Father's Name">
    </div>
    <div>
        <label>Father's Occupation:</label>
        <input type="text" name="fathers_occupation" value="<?php echo htmlspecialchars(ucwords($fathers_occupation)); ?>" placeholder="Father's Occupation">
    </div>
    
    <!-- Mother's Information -->
    <div>
        <label>Mother's Name:</label>
        <input type="text" name="learners_mother" value="<?php echo htmlspecialchars(ucwords($learners_mother)); ?>" placeholder="Mother's Name">
    </div>
    <div>
        <label>Mother's Occupation:</label>
        <input type="text" name="mothers_occupation" value="<?php echo htmlspecialchars(ucwords($mothers_occupation)); ?>" placeholder="Mother's Occupation">
    </div>
    
    <!-- Guardian -->
    <div>
        <label>Guardian:</label>
        <input type="text" name="learner_guardian" value="<?php echo htmlspecialchars(ucwords($learner_guardian)); ?>" placeholder="Guardian Name">
    </div>

    <!-- Submit Button -->
    
</div>

    <button type="submit" style="
        background-color: gray; 
        color: white; 
        padding: 5px 10px; 
        border: none; 
        border-radius: 5px; 
        font-size: 16px; 
        cursor: pointer; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        transition: background-color 0.3s ease, transform 0.2s ease;">
        Save Changes
    </button>
</div>

        </div>
    </form>
</div>


        <div class="tab-content" id="family">
        <?php 
    $quer3 = $conn->prepare("SELECT * FROM attendance WHERE learner_id=:id6");
    $quer3->bindParam(":id6", $id);
    $quer3->execute();

    $attendances = $quer3->fetchAll(PDO::FETCH_ASSOC);
?>
<h5>Days of Present</h5>

<!-- Display Present Days -->
<div class="calendar-container present-days">
    
    <?php foreach ($attendances as $attendance): ?>
        <?php if ($attendance['status'] == 'Present'): ?>
            <div class="calendar present">
                <div class="calendar-header">
                    <span class="month"><?php echo date('F', strtotime($attendance['attendance_date'])); ?></span>
                    <span class="day"><?php echo date('d', strtotime($attendance['attendance_date'])); ?></span>
                </div>
                <div class="calendar-body">
                    <span class="year"><?php echo date('Y', strtotime($attendance['attendance_date'])); ?></span>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<h5>Days of Absent</h5>

<!-- Display Absent Days -->
<div class="calendar-container absent-days">
    
    <?php foreach ($attendances as $attendance): ?>
        <?php if ($attendance['status'] == 'Absent'): ?>
            <div class="calendar absent">
                <div class="calendar-header">
                    <span class="month"><?php echo date('F', strtotime($attendance['attendance_date'])); ?></span>
                    <span class="day"><?php echo date('d', strtotime($attendance['attendance_date'])); ?></span>
                </div>
                <div class="calendar-body">
                    <span class="year"><?php echo date('Y', strtotime($attendance['attendance_date'])); ?></span>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>



        </div>
        <div class="tab-content" id="module">
            <?php 
            
            $quer2 = $conn->prepare("SELECT * FROM module_assigned where learner_id=:id4");

            $quer2->bindParam(":id4", $id);
            $quer2->execute();

            $row4 = $quer2->fetch(PDO::FETCH_ASSOC);

            $module_id = $row4['module_id'];
            $query2 = $conn->prepare("SELECT * FROM module where module_id=:id5");

            $query2->bindParam(":id5", $module_id);
            $query2->execute();
            $module = $query2->fetch(PDO::FETCH_ASSOC);
            
            ?>
            <div style="border:solid 1px gray; padding:10px 5px 0px 5px">
            <h6><?php echo htmlspecialchars($module['module_name']); ?></h6>
            <p><?php echo htmlspecialchars($module['filetype']); ?></p>
            </div>
        </div>
        <div class="tab-content" id="ordinances">
            <p>Ordinances content goes here...</p>
        </div>
        <div class="tab-content" id="facilitator">
        <div class="info-grid">
            <?php 
            $quer = $conn->prepare("SELECT * FROM class_facilitator where learner_id=:id2");

            $quer->bindParam(":id2", $id);
            $quer->execute();

            $row2 = $quer->fetch(PDO::FETCH_ASSOC);

            $teacher_id = $row2['teacher_id'];
            $query = $conn->prepare("SELECT * FROM teacher where teacher_id=:id3");

            $query->bindParam(":id3", $teacher_id);
            $query->execute();
            $row3 = $query->fetch(PDO::FETCH_ASSOC);

            $teacher_name = $row3['first_name'];
            $teacher_lastname = $row3['last_name'];
            $teacher_gender = $row3['gender'];
            $teacher_email = $row3['email'];
            $teacher_subject = $row3['subject_specialization'];

            ?>
            <div><span>Teacher's Full name: </span><?php echo ucwords($teacher_name) .' '.ucwords($teacher_lastname); ?></div>
            <div><span>Teacher' gender: </span><?php echo ucwords($teacher_gender); ?></div>
            <div><span>Teacher specialization: </span><?php echo ucwords($teacher_subject); ?></div>
            <div><span>Teacher' email: </span><?php echo ucwords($teacher_email); ?></div>
        </div>
    </div>

    <script>
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const targetTab = button.getAttribute('data-tab');

                tabContents.forEach(content => {
                    content.classList.remove('active');
                    if (content.id === targetTab) {
                        content.classList.add('active');
                    }
                });
            });
        });

        document.querySelector('.alien-toggle-button').addEventListener('click', function () {
            const menu = document.querySelector('.extraterrestrial-menu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });

        // Close the dropdown if clicked outside
        window.addEventListener('click', function (event) {
            if (!event.target.matches('.alien-toggle-button')) {
                const dropdowns = document.querySelectorAll('.extraterrestrial-menu');
                dropdowns.forEach(dropdown => dropdown.style.display = 'none');
            }
        });
    </script>
</body>
</html>
