<?php



include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/navbar.php");


?>



<?php 
     $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
     if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        
            $stmtss = $conn->prepare("SELECT t.teacher_id, t.first_name, t.middle_name, t.last_name, t.email, t.subject_specialization, t.gender, t.age, t.contact_number,
                                ta.street, ta.barangay, ta.city, ta.province, ta.zid_code
                         FROM teacher t
                         INNER JOIN teacher_address ta ON t.teacher_id = ta.teacher_id
                         WHERE t.teacher_id = :id");

$stmtss->bindParam(":id", $id);
$stmtss->execute();

$row = $stmtss->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $lastname = $row['last_name'];
    $firstname = $row['first_name'];
    $middlename = $row['middle_name'];
    $gender = $row['gender'];
    $email = $row['email'];
    $age = $row['age'];
    $subject_specialization = $row['subject_specialization'];
    $contact = $row['contact_number'];

    // Address information
    $street = $row['street'];
    $barangay = $row['barangay'];
    $city = $row['city'];
    $province = $row['province'];
    $zid_code = $row['zid_code'];
} else {
    echo "No teacher found with the given ID.";
}
 }       ?>

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

        .learner-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-family: Arial, sans-serif;
        font-size: 14px;
        text-align: left;
        box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1); /* Shadow effect */
    }

    .learner-table th, 
    .learner-table td {
        border: 1px solid #ddd; /* Add borders */
        padding: 12px;
    }

    .learner-table th {
        background-color: #333; /* Dark background for header */
        color: white; /* White text for contrast */
        font-weight: bold;
        text-transform: uppercase;
    }

    .learner-table tr:nth-child(even) {
        background-color: #f9f9f9; /* Zebra striping for rows */
    }

    .learner-table tr:hover {
        background-color: #f1f1f1; /* Row hover effect */
        cursor: pointer;
    }
    
    </style>
</head>
<body style="background-color:#fff;font-family: Arial, sans-serif;">
    <div class="containerss" style="margin-top:80px;">
        <div class="headerss">
        
            <h1 style="margin-bottom:40px"> <a href="instructor.php"><i class="ri-arrow-left-line" style="margin-right:20px"></i></a>Teacher Information</h1>
            <button>Print</button>
        </div>
        <div class="profiless">
            <img src="<?php 
                if($gender == 'Male') { echo '../assets/img/boy.png'; }
                elseif($gender == 'Female') { echo '../assets/img/girl.png'; }
            ?>" alt="Profile Picture">
            <div class="infoss">
                <h3><strong><?php echo $lastname . ' ' . $firstname . ' ' . $middlename; ?></strong></h3>
                <p style="font-size: 14px">ID: 012-0755-1857</p>
                <div class="alien-dropdown-container">
                <button class="alien-toggle-button">Action <i class="ri-arrow-down-s-fill"></i></button>
                <div class="extraterrestrial-menu">
                    <a href="#">Archive</a>
                    <a href="teacher_edit.php?id=<?php echo $id; ?>">Edit</a>

                </div> 
            </div>
            </div>
        </div>

        <div class="tabsss">
            <button class="tab-button active" data-tab="individual">Individual</button>
            <button class="tab-button" data-tab="module">Students</button>
            
        </div>

        <div class="tab-content active" id="individual">
        <div class="info-grid">
            <div><span>Teacher Name: </span><?php echo ucwords($firstname) . ' ' . ucwords($middlename) . ' ' . ucwords($lastname); ?></div>
            <div><span>Preferred Name: </span><?php echo ucwords($firstname); ?></div>
            <div><span>Birth Country:</span> Philippines</div>
            <div><span>Gender: </span><?php echo ucwords($gender); ?></div>
            <div><span>Contact number: </span><?php echo ucwords($contact); ?></div>
            <div><span>Mailing Address: </span><?php echo ucwords($email); ?></div>
            <div><span>Age: </span><?php echo $age; ?></div>
            <div><span>Subject Specialization: </span><?php echo ucwords($subject_specialization); ?></div>

            <!-- Address Details -->
            <div><span>Street: </span><?php echo ucwords($street); ?></div>
            <div><span>Barangay: </span><?php echo ucwords($barangay); ?></div>
            <div><span>City: </span><?php echo ucwords($city); ?></div>
            <div><span>Province: </span><?php echo ucwords($province); ?></div>
            <div><span>ZID Code: </span><?php echo $zid_code; ?></div>
        </div>
    </div>


        <div class="tab-content" id="module">
            <table class="learner-table">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Middle Name</th>
                </tr>

                <?php 
                    $quer2 = $conn->prepare("SELECT * FROM learner WHERE teacher_id=:id4");
                    $quer2->bindParam(":id4", $id);
                    $quer2->execute();

                    while ($row4 = $quer2->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row4['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row4['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($row4['middlename']); ?></td>
                    </tr>
                <?php } ?>
            </table>

        
            
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
