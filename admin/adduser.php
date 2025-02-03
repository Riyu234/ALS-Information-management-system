<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/navbar.php");

$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

// Check if "student" or "teacher" is selected
$tableType = isset($_GET['table']) ? $_GET['table'] : 'student'; // Default is 'student'

// Initialize the current page
$currentPage = isset($_GET['currentPage']) ? $_GET['currentPage'] : 1; // Current page
$recordsPerPage = 5;

// Query to fetch all records for students or teachers
if ($tableType == 'student') {
    $stmt = $conn->prepare("SELECT learner_id, firstname, lastname FROM learner WHERE account <> 'yes'");
} elseif ($tableType == 'teacher') {
    $stmt = $conn->prepare("SELECT teacher_id, first_name, last_name FROM teacher WHERE account <> 'yes'");
}


$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pagination logic
$start = ($currentPage - 1) * $recordsPerPage;
$users = array_slice($users, $start, $recordsPerPage);

// Calculate total pages
$totalPages = ceil(count($users) / $recordsPerPage);
?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#attendanceTable tbody tr'); // Select rows in tbody only

            rows.forEach(row => {
                const rowData = row.innerText.toLowerCase();
                if (rowData.includes(searchValue)) {
                    row.style.display = ''; // Show row if it matches search query
                } else {
                    row.style.display = 'none'; // Hide row if it doesn't match
                }
            });
        });

        // Add event listener to the dropdown buttons
        const dropdownButtons = document.querySelectorAll('.dropdown-btn');

        dropdownButtons.forEach(button => {
            button.addEventListener('click', function() {
                const dropdownContent = this.nextElementSibling; // Get the associated dropdown content

                // Toggle the display of the dropdown content
                if (dropdownContent.style.display === 'block') {
                    dropdownContent.style.display = 'none';
                } else {
                    dropdownContent.style.display = 'block';
                }
            });
        });

        // Close dropdown if clicked outside of it
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-content').forEach(content => {
                    content.style.display = 'none';
                });
            }
        });

        // Open the 'Add' Modal
        const addButtons = document.querySelectorAll('.modal-trigger');
        addButtons.forEach(button => {
            button.addEventListener('click', function() {
                const learnerId = this.getAttribute('data-id');
                const firstName = this.getAttribute('data-firstname');
                
                // Set the modal input fields with the retrieved data
                const modal = document.getElementById('addModal');
                const firstNameField = modal.querySelector('#firstName');
                const learnerIdField = modal.querySelector('#learnerId'); // Optional: if you want to store learner_id in a hidden field
                
                firstNameField.value = firstName;  // Set the firstname
                learnerIdField.value = learnerId; // Set the learner_id if you need it
                modal.style.display = 'block';  // Open the modal
            });
        });

        // Close 'Add' Modal when the close button is clicked
        const closeAddModalBtn = document.getElementById('closeAddModalBtn');
        closeAddModalBtn.addEventListener('click', function() {
            const modal = document.getElementById('addModal');
            modal.style.display = 'none';
        });

        // Close 'Add' Modal if clicked outside of modal content
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('addModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body style="background-color: #fff">
    <div class="addcon">
        <div style="display: flex; align-items: center;">
            <a href="users.php"><i class="ri-arrow-left-line" style="font-size: 20px;margin-right: 20px;"></i></a>
            <h1 style="font-weight: 800;">Manage Users</h1>
        </div>
        <hr>

        <div style="margin-bottom: 20px;">
            <a href="?table=student" style="margin-right: 20px; font-size: 18px;">Student</a>
            <a href="?table=teacher" style="font-size: 18px;">Teacher</a>
            <button class="open-modal-btn" id="openModalBtn" style="background-color: white;color: blue">Add new Admin</button>
        </div>

        <!-- Search Input -->
        <input type="text" id="searchInput" placeholder="Search users..." style="margin-bottom: 20px; padding: 10px; width: 100%; border-radius: 4px; border: 1px solid #ddd;">

        <table class="styled-table" id="attendanceTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?php echo $start + $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($user['firstname'] ?? $user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['lastname'] ?? $user['last_name']); ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="dropdown-btn">Actions</button>
                                <div class="dropdown-content">
                                    <!-- Pass learner_id to modal via data-id -->
                                    <button class="modal-trigger" sty data-id="<?php echo $user['learner_id'] ?? $user['teacher_id']; ?>"  style="background-color: white;color: gray"data-firstname="<?php echo htmlspecialchars($user['firstname'] ?? $user['first_name']); ?>" data-target="modal">Add</button>
                                    
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-container">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?table=<?php echo $tableType; ?>&currentPage=<?php echo $i; ?>" <?php echo $i == $currentPage ? 'style="font-weight: bold;"' : ''; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>

    <!-- New Modal for Add Button -->
    <div id="addModal" class="modal" style="border:solid 1px gray; margin-top: 50px">
    <div class="modal-content" style="max-width: 400px; margin: 50px auto; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background: #fff; position: relative;">
        <span class="close-btn" id="closeAddModalBtn" style="position: absolute; top: 10px; right: 15px; cursor: pointer; font-size: 18px;">&times;</span>
        <h2 style="text-align: center; margin-bottom: 20px; font-size: 1.5em; color: #333;">Add User</h2>
        <form action="insert_user.php" method="post" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="hidden" id="learnerId" name="learnerId">

            <label for="firstName" style="font-size: 14px; font-weight: bold; color: #555;">Username</label>
            <input type="text" id="firstName" name="firstName" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">

            <label for="lastName" style="font-size: 14px; font-weight: bold; color: #555;">Password</label>
            <input type="text" id="lastName" name="lastName" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">

            <label for="userType" style="font-size: 14px; font-weight: bold; color: #555;">User Type</label>
            <select id="userType" name="userType" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>

            <button type="submit" class="btn" style="background: #4CAF50; color: #fff; padding: 10px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.3s;">
                Add User
            </button>
        </form>
    </div>
</div>
<div id="modalOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;" onclick="hideModal()"></div>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form Modal</title>
    <style>
        /* Modal Styles */
        .modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
    margin-top: 50px;
}
.animals {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
    position: relative;
    z-index: 1001;
}
.animals h2 {
    text-align: center;
    margin-bottom: 20px;
}
.animals .form-group {
    margin-bottom: 15px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.animals .form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    flex: 1 1 100%;
}
.animals .form-group input,
.animals .form-group select {
    flex: 1 1 calc(50% - 10px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.animals .form-group input:focus,
.animals .form-group select:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
.animals .form-group input::placeholder {
    color: #888;
    font-style: italic;
}
.animals .submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    border: none;
    color: #fff;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}
.animals .submit-btn:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}
.animals .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    border: none;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
    color: #333;
    transition: color 0.3s;
}
.animals .close-btn:hover {
    color: #000;
}
/* Button to Open Modal */
.open-modal-btn {
    padding: 5px 10px;
    background-color: #007bff;
    border: none;
    margin-left: 10px;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}
.open-modal-btn:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>

<!-- Button to Open Modal -->


<!-- Modal -->
<div style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; justify-content: center; align-items: center;" id="modalOverlay">
    <div style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 100%; max-width: 800px; position: relative; z-index: 1001;" class="animals">
        <button style="position: absolute; top: 10px; right: 10px; background: transparent; border: none; font-size: 20px; font-weight: bold; cursor: pointer; color: #333;" id="closeModalBtn">&times;</button>
        <h2 style="text-align: center; margin-bottom: 20px;">Registration Form</h2>
        <form action="add_min.php" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <!-- Last Name -->
            <div style="margin-bottom: 15px;">
                <label for="lastname" style="display: block; margin-bottom: 5px; font-weight: bold;">Last Name:</label>
                <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            </div>

            <!-- First Name -->
            <div style="margin-bottom: 15px;">
                <label for="firstname" style="display: block; margin-bottom: 5px; font-weight: bold;">First Name:</label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            </div>

            <!-- Middle Name -->
            <div style="margin-bottom: 15px;">
                <label for="middlename" style="display: block; margin-bottom: 5px; font-weight: bold;">Middle Name:</label>
                <input type="text" id="middlename" name="middlename" placeholder="Enter your middle name" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            </div>

            <!-- Email -->
            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            </div>

            <!-- Username -->
            <div style="margin-bottom: 15px;">
                <label for="username" style="display: block; margin-bottom: 5px; font-weight: bold;">Username:</label>
                <input type="text" id="username" name="username" placeholder="Choose a username" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            </div>

            <!-- Password -->
            <div style="margin-bottom: 15px;">
                <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold;">Password:</label>
                <input type="password" id="password" name="password" placeholder="Choose a password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            </div>

            <!-- Animal Class -->
            <div style="margin-bottom: 15px;">
                <label for="animal_class" style="display: block; margin-bottom: 5px; font-weight: bold;">Animal Class:</label>
                <select id="animal_class" name="animal_class" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
                    <option value="none">Admin</option>
                    <option value="admin">Admin</option>
                    
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" style="width: 100%; padding: 10px; background-color: #007bff; border: none; color: #fff; border-radius: 5px; font-size: 16px; cursor: pointer; grid-column: span 2;">Register</button>
        </form>
    </div>
</div>



<script>
    // JavaScript for Modal
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modalOverlay = document.getElementById('modalOverlay');

    openModalBtn.addEventListener('click', () => {
        modalOverlay.style.display = 'flex';
    });

    closeModalBtn.addEventListener('click', () => {
        modalOverlay.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            modalOverlay.style.display = 'none';
        }
    });
</script>

</body>
</html>


</body>
</html>

<style>
    .addcon {
        width: 90%;
        margin: 100px auto;
        padding: 20px;
    }

    .styled-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .styled-table th, .styled-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .styled-table th {
        background-color: #f4f4f4;
    }

    .styled-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .styled-table button {
        background-color: #4CAF50;
        color: white;
        padding: 5px 10px;
        margin-right: 5px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .styled-table button:hover {
        background-color: #45a049;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination-container a {
        padding: 5px 10px;
        margin: 0 5px;
        border: 1px solid #ddd;
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }

    .pagination-container a:hover {
        background-color: #007bff;
        color: white;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-btn {
        background-color: #4CAF50;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        color: black;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
    }

    .modal-content {
        border:solid 1px gray;
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 8px;
    }

    .close-btn {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 25px;
        cursor: pointer;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #45a049;
    }
</style>

<?php include("../includes/footer.php"); ?>
