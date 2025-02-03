<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Custom Attendance Table</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <style>
    .table-containers {
      width: 90%;
      padding: 20px;
      border-radius: 20px;
      margin: 100px auto;
    }

    .search-bar {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    h1 {
      display: inline-block;
    }

    .controls-container {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #fff;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .btn-edit {
      background-color: #007bff;
      color: white;
      border-radius: 5px;
      border: none;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .btn-edit:hover {
      background-color: #0056b3;
    }

    .dropdown {
      position: relative;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 5px;
      min-width: 150px;
      z-index: 1;
      box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }

    .dropdown-content.active {
      display: block;
    }

    .pagination-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px;
    }

    .pagination-button {
      padding: 5px 10px;
      margin: 0 5px;
      border: 1px solid #ddd;
      border-radius: 5px;
      cursor: pointer;
    }

    .pagination-button.active {
      background-color: #007bff;
      color: white;
    }

    .pagination-select {
      margin-left: 15px;
      padding: 5px;
    }

    td {
      border-top: solid 1px lightgray;

    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 50%;
      
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fff;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 50%;
      border-radius: 10px;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
    .modal input{
      width: 100%;

    }
  </style>
</head>
<body >
  <?php
  
  include("../includes/header.php");
  include("../includes/sidebar.php");
  include("../includes/navbar.php");
  ?>

  <!-- Modal -->
  <div id="userModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>User Details</h2>
    
    <form id="userForm" action="update_password.php" method="post">
      <label for="firstname">User Name:</label>
      <input type="text" id="firstname" name="firstname" placeholder="Enter User Name" required>
      
      <input type="hidden" id="userId" name="user_id" readonly>
      
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      
      <div class="form-actions">
        <button type="submit">Change Password</button>
        <button type="button" onclick="closeModal()">Close</button>
      </div>
    </form>
  </div>
</div>

<style>
/* Modal Background */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  padding-top: 60px;
  overflow: auto;

}

/* Modal Content */
.modal-content {

  background-color: white;
  margin: auto;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 500px; /* Limit the width */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  position: relative;
  animation: fadeIn 0.3s ease-out;
  margin-top: 100px;
}

/* Animation for modal appearance */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Close Button */
.close {
  color: #aaa;
  font-size: 30px;
  font-weight: bold;
  position: absolute;
  top: 10px;
  right: 20px;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

/* Title */
h2 {
  font-size: 22px;
  color: #333;
  text-align: center;
  font-weight: 600;
  margin-bottom: 20px;
}

/* Form Fields */
label {
  font-size: 16px;
  font-weight: bold;
  color: #555;
  margin-bottom: 8px;
  display: block;
}

input[type="text"], input[type="password"] {
  width: 100%;
  padding: 12px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
  background-color: #f9f9f9;
}

input[type="text"]:focus, input[type="password"]:focus {
  border-color: #007bff;
  outline: none;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Form Actions (Buttons) */
.form-actions {
  text-align: center;
}

.form-actions button {
  background-color: #007bff;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  width: 100%;
  margin-bottom: 10px;
}

.form-actions button[type="button"] {
  background-color: #f44336;
}

.form-actions button:hover {
  background-color: #0056b3;
}

.form-actions button[type="button"]:hover {
  background-color: #d32f2f;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
  .modal-content {
    width: 90%;
    padding: 15px;
  }

  h2 {
    font-size: 20px;
  }

  input[type="text"], input[type="password"] {
    padding: 10px;
    font-size: 14px;
  }

  .form-actions button {
    font-size: 14px;
  }
}
</style>






  <div class="table-containers">
    <div class="controls-container">
      <h1 style="font-weight: 800;"><i class="ri-user-fill"></i>Users</h1>
      <a href="adduser.php" style="margin-left:auto; margin-right: 20px; background-color: white">
        <button style="background-color: white;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);border: none;padding: 5px;position: absolute;right: 200px"><i class="ri-user-add-fill"></i> Add User</button>
      </a>

      <div>
        <label for="rowsPerPage">Rows per page: </label>
        <select id="rowsPerPage" class="pagination-select" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);border: none;">
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="30">30</option>
          <option value="40">40</option>
          <option value="50">50</option>
        </select>
      </div>
    </div>

    <input type="text" id="searchInput" class="search-bar" placeholder="Search table..." style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);">
    <table style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);">
      <thead>
        <tr>
          <th style="width: 15%;background-color:  lightgray">No.</th>
          <th style="width: 23%;background-color: lightgray">First Name</th>
          <th style="width: 23%;background-color: lightgray">Last Name</th>
          <th style="width: 23%;background-color:  lightgray">Role</th>
          <th style="width: 100px; text-align: center;;background-color:  lightgray">Action</th>
        </tr>
      </thead>
      <tbody id="attendanceTable">
        <?php

          $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

        $stmt2 = $conn->prepare(
          "SELECT 
            user.role AS role,
            user.user_id,
            user.username,
            learner.lastname AS learner_lastname,
            learner.firstname AS learner_firstname,
            teacher.last_name AS teacher_lastname,
            teacher.first_name AS teacher_firstname,
            admin.lastname AS admin_lastname,
            admin.firstname AS admin_firstname
          FROM 
            user
          LEFT JOIN 
            learner ON user.student_id = learner.learner_id
          LEFT JOIN 
            teacher ON user.teacher_id = teacher.teacher_id
          LEFT JOIN 
            admin ON user.admin_id = admin.admin_id"
        );


        $counter = 1;
        if ($stmt2->execute()) {
          while ($users = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $firstName = $lastName = $role = "";
            $userId = $users['user_id'];
            $username = $users['username'];
             // Assuming user_id is part of your SELECT query
            
            if (!empty($users['learner_firstname'])) {
              $firstName = $users['learner_firstname'];
              $lastName = $users['learner_lastname'];
              $role = "student";
            } elseif (!empty($users['teacher_firstname'])) {
              $firstName = $users['teacher_firstname'];
              $lastName = $users['teacher_lastname'];
              $role = "teacher";
            } elseif (!empty($users['admin_firstname'])) {
              $firstName = $users['admin_firstname'];
              $lastName = $users['admin_lastname'];
              $role = "admin";
            }
        ?>
            <tr>
              <td style="border-top: solid 1px lightgray"><?php echo $counter++; ?></td>
              <td style="border-top: solid 1px lightgray"><?php echo htmlspecialchars($firstName); ?></td>
              <td style="border-top: solid 1px lightgray"><?php echo htmlspecialchars($lastName); ?></td>
              <td style="border-top: solid 1px lightgray"><?php echo htmlspecialchars($role); ?></td>
              <td style="border-top: solid 1px lightgray" >
                <div class="dropdown" style="text-align: center;">
                  <button class="btn-edit" onclick="toggleDropdown(<?php echo $counter; ?>)">
                    <i class="ri-pencil-line"></i> Edit
                  </button>
                  <div id="dropdown-<?php echo $counter; ?>" class="dropdown-content">
                    <button class="btn-view" onclick="openModal('<?php echo htmlspecialchars($username); ?>', '<?php echo $userId; ?>')">
                        Change pass
                    </button>
                  </div>
                </div>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<tr><td colspan='5'>No records found</td></tr>";
        }
        ?>

      </tbody>
      <button class="btn-inactive" onclick="print()" style="border: none;background-color: white;float:right; margin-bottom: 10px;padding: 10px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);"><i class="ri-printer-fill"></i> print</button>
    </table>

    <div class="pagination-container">
      <button class="pagination-button" onclick="previousPage()" style="background-color: white;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);">Previous</button>
      <button class="pagination-button" onclick="nextPage()" style="background-color: white;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);">Next</button>
    </div>
  </div>

  <?php include("../includes/footer.php"); ?>

  <script>
    let currentDropdown = null;

    function toggleDropdown(index) {
      const dropdown = document.getElementById(`dropdown-${index}`);
      if (dropdown.classList.contains('active')) {
        dropdown.classList.remove('active');
        currentDropdown = null;
      } else {
        closeDropdowns();
        dropdown.classList.add('active');
        currentDropdown = dropdown;
      }
    }

    function closeDropdowns() {
      if (currentDropdown) {
        currentDropdown.classList.remove('active');
        currentDropdown = null;
      }
    }

    document.addEventListener('click', (event) => {
      if (!event.target.closest('.dropdown')) {
        closeDropdowns();
      }
    });

    function openModal(firstName, userId) {
  document.getElementById('userModal').style.display = 'block';
  document.getElementById('firstname').value = firstName;
  document.getElementById('userId').value = userId;  // Set user ID in the modal form

  // Hide the button after clicking it
  document.getElementById(buttonId).style.display = 'none';
}


    function closeModal() {
      document.getElementById('userModal').style.display = 'none';
      document.getElementById('userForm').reset();
    }

    function changePassword() {
      const password = document.getElementById('password').value;
      if (password) {
        alert('Password changed successfully!');
      } else {
        alert('Please enter a new password.');
      }
    }

    let currentPage = 1;
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    const tableBody = document.getElementById('attendanceTable');
    const searchInput = document.getElementById('searchInput');

    function paginateTable() {
      const rows = Array.from(tableBody.querySelectorAll('tr'));
      const rowsPerPage = parseInt(rowsPerPageSelect.value, 10);
      const totalRows = rows.length;

      rows.forEach((row, index) => {
        row.style.display =
          index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage
            ? ''
            : 'none';
      });
    }

    function previousPage() {
      if (currentPage > 1) {
        currentPage--;
        paginateTable();
      }
    }

    function nextPage() {
      const rows = tableBody.querySelectorAll('tr');
      const rowsPerPage = parseInt(rowsPerPageSelect.value, 10);
      if (currentPage * rowsPerPage < rows.length) {
        currentPage++;
        paginateTable();
      }
    }

    rowsPerPageSelect.addEventListener('change', () => {
      currentPage = 1;
      paginateTable();
    });

    searchInput.addEventListener('input', () => {
      const searchTerm = searchInput.value.toLowerCase();
      const rows = Array.from(tableBody.querySelectorAll('tr'));

      rows.forEach((row) => {
        const cells = row.querySelectorAll('td');
        const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
        row.style.display = rowText.includes(searchTerm) ? '' : 'none';
      });
    });

    paginateTable();
  </script>
</body>
</html>
