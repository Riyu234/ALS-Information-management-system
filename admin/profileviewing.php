<?php



$sidebar = "../includes/sidebar.php";
include("../includes/header.php");
if($_SESSION['role'] == "teacher"){
    $sidebar = "../teacher/teachersidebar.php";
} 
include($sidebar);
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
        
            <h1 style="margin-bottom:40px"> <a href="<?php if($_SESSION['role'] == "teacher"){
                        echo "../teacher/teacherstudent.php";
                    } else{
                          echo "../admin/student.php";
                    } ?>"><i class="ri-arrow-left-line" style="margin-right:20px"></i></a>Learner Information</h1>
            
        </div>
        <div class="profiless">
            <img src="<?php 
                if($gender == 'Male') { echo '../assets/img/boy.png'; }
                elseif($gender == 'Female') { echo '../assets/img/girl.png'; }
            ?>" alt="Profile Picture">
            <div class="infoss">
                <h3><strong><?php echo $lastname . ' ' . $firstname . ' ' . $middlename; ?></strong></h3>
                <p style="font-size: 14px">ID: 012-0755-1857 | STATUS: 	<?php echo  ' ' . ucfirst($status); ?>  </p>
                <div class="alien-dropdown-container">
                <button class="alien-toggle-button">Action <i class="ri-arrow-down-s-fill"></i></button>
                <div class="extraterrestrial-menu">
                    <a href="status_process.php?id=<?php echo $id; ?>"><?php if($status == "active"){
                    	echo "Mark as Inactive";}
                    	else{
                    	echo "Mark as Active";
                    	}
                    ?></a>
                    <a href="#">Archive</a>

                    <a href="profile_edit.php?id=<?php echo $id; ?>" style="<?php if($_SESSION['role'] == "teacher"){

                        echo "display: none";
                    } else{
                          echo "display: block";
                    } ?>">Edit</a> 

                    <a href="../teacher/assignmod.php?id=<?php echo $id; ?>" style="<?php if($_SESSION['role'] == "teacher"){
                        echo "display: block";
                    } else{
                          echo "display: none";
                    } ?>">Add module</a> 
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
    <div class="info-grid">
        <div><span>Learner Name: </span><?php echo ucwords($firstname) . ' ' . ucwords($middlename) . ' ' . ucwords($lastname); ?></div>
        
        <div><span>Preferred Name: </span><?php echo ucwords($firstname); ?></div>
        <div><span>Birth Country: </span>Philippines</div>
        <div><span>Birth Date: </span><?php echo ucwords($birthdate); ?></div>
        <div><span>Current Address: </span><?php echo ucwords($municipality); ?></div>
        <div><span>Gender: </span><?php echo ucwords($gender); ?></div>
        
        <div><span>Contact number: </span><?php echo ucwords($contact_number); ?></div>
        <div><span>Residential Address: </span><?php echo ucwords($barangay) . ', ' . ucwords($municipality) . ', ' . ucwords($zipcode) . ', ' . ucwords($province); ?></div>
        <div><span>Civil Status: </span><?php echo ucwords($civil_status); ?></div>
        <div><span>Mailing Address: </span><?php echo ucwords($email); ?></div>
        
        <!-- New fields from learner_parents -->
        <div><span>Father's Name: </span><?php echo ucwords($learners_father); ?></div>
        <div><span>Father's Occupation: </span><?php echo ucwords($fathers_occupation); ?></div>
        <div><span>Mother's Name: </span><?php echo ucwords($learners_mother); ?></div>
        <div><span>Mother's Occupation: </span><?php echo ucwords($mothers_occupation); ?></div>
        <div><span>Guardian: </span><?php echo ucwords($learner_guardian); ?></div>
    </div>
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
    // Query to get all modules assigned to the learner
    $quer2 = $conn->prepare("SELECT * FROM module_assigned WHERE learner_id = :id4");
    $quer2->bindParam(":id4", $id);
    $quer2->execute();

    // Fetch all rows from the 'module_assigned' table
    $assignedModules = $quer2->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the assigned modules
    foreach ($assignedModules as $row4) {
        $module_id = $row4['module_id'];

        // Fetch the module details for each module_id
        $query2 = $conn->prepare("SELECT * FROM module WHERE module_id = :id5");
        $query2->bindParam(":id5", $module_id);
        $query2->execute();

        // Loop through the fetched module details
        while ($module = $query2->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <div style="border:solid 1px gray; padding:10px 5px 0px 5px; margin-top: 10px">
            <a href="../admin/view2.php?id=<?php echo $module['module_id']; ?>"><h6><?php echo htmlspecialchars($module['module_name']); ?></h6></a>
            
            
        </div>
    <?php
        }
    }
    ?>
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
            <button onclick="showModal()" style="width: 130px;background-color: gray;color: white;border: none;padding: 5px">Change Teacher</button>
            <a href=""></a>
            <div id="teacherModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 20px; border: 1px solid #ccc; background: #fff; z-index: 1000; border: none;width: 20%;">
    <h3>Select a Teacher</h3>
    <form action="change_teacher.php" method="POST">
        <div>
            <label for="teacherSelect">Teacher</label>
            <select id="teacherSelect" name="teacher_id" required onchange="updateTeacherId()">
                <option value="" disabled selected style="padding: 10px">Select a teacher</option>
                <?php
                $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

                $query = "SELECT teacher_id, first_name, middle_name, last_name FROM teacher";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($teachers as $teacher) {
                    $fullName = $teacher['first_name'] . ' ' . $teacher['middle_name'] . ' ' . $teacher['last_name'];
                    echo "<option value=\"{$teacher['teacher_id']}\">$fullName</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="teacherId">Teacher ID</label>
            <input type="hidden" id="teacherId" name="selected_teacher_id">
        </div>
        <div>
            <label for="getId">GET ID</label>
            <input type="text" id="getId" name="get_id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" readonly>
        </div>
        <div style="margin-top: 20px;">
            <button type="button" onclick="hideModal()">Close</button>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

<script>
    function updateTeacherId() {
        const selectedTeacherId = document.getElementById('teacherSelect').value;
        document.getElementById('teacherId').value = selectedTeacherId;
    }
</script>

        </form>
    </div>
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
    <?php include("../includes/footer.php"); ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Modal</title>
</head>
<body>
    <!-- Button to trigger modal -->
    

    <!-- Modal -->
    

    <!-- Modal Background Overlay -->
    <div id="modalOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;" onclick="hideModal()"></div>

    <script>
        function showModal() {
            document.getElementById('teacherModal').style.display = 'block';
            document.getElementById('modalOverlay').style.display = 'block';
        }

        function hideModal() {
            document.getElementById('teacherModal').style.display = 'none';
            document.getElementById('modalOverlay').style.display = 'none';
        }
    </script>
</body>
</html>

</body>
</html>
