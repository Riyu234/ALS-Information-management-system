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
  <title>Custom Attendance Table</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <style>
    .table-containers {
      width: 90%;
      padding: 20px;
      border-radius: 20px;
      
      margin-left: 20px;
      margin:100px auto;
     
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
      background-color: lightblue;
      
      border-bottom: solid 4px lightgray;
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

    .status-active {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
    }

    .status-inactive {
      background-color: #dc3545;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
    }

    table th:nth-child(6), table td:nth-child(6) {
      width: 100px; /* Adjust width as per your requirement */
      text-align: center; /* Ensure the action buttons are centered */
    }

    td{
      border-top: solid 1px lightgray;
    }

  </style>
</head>
<body >

<div class="table-containers">
  <div class="controls-container">
    <h1 style="font-weight: 800; "><i class="ri-presentation-fill"></i> Instructor</h1>
    <a href="addteacher.php" style="margin-left:auto; margin-right: 20px;"><button style="margin-left:auto; margin-right: 20px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06); background-color: white; border: none;padding: 10px"><i class="ri-add-fill"></i>Add Instructor</button></a>
    <button type="button" class="btn-custom" id="openModalButton" style="width: 100px; margin-right: 10px;height: 40px;text-align: center;display: flex;align-items: center;background-color: white;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);margin-top: -4px;color: black;font-size: 15px">
  Assign
</button>


    <div>
      <label for="rowsPerPage">Rows per page: </label>
      <select id="rowsPerPage" class="pagination-select" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);border: none">
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
        <th style="width: 15%">No.</th>
        <th style="width: 23%">First Name</th>
        <th style="width: 23%">Last Name</th>
        <th style="width: 23%">Middle Name</th>
      
        <th style="width: 100px; text-align: center; ">Action</th>
      </tr>
    </thead>
    <tbody id="attendanceTable">
    <?php 
    $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
    $sqll = $conn->prepare("SELECT * FROM teacher");
    $counter = 1;

    if ($sqll->execute()) {
      while ($teachers = $sqll->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td style="width: 15%"><?php echo $counter; ?></td>
        <td style="width: 23%"><?php echo $teachers['first_name']; ?></td>
        <td style="width: 23%"><?php echo $teachers['last_name']; ?></td>
        <td style="text-align:left;"><?php echo $teachers['middle_name']; ?></td>
       
        <td>
          <div class="dropdown" style="text-align: center;">
            <button class="btn-edit" onclick="toggleDropdown(this)">
              <i class="ri-pencil-line"></i> Edit
            </button>
            <div class="dropdown-content" style="text-align: center;">
              <a href="teacherview.php?id=<?php echo $teachers['teacher_id'] ?>"></i> View</a>
              
            </div>
          </div>
        </td>
      </tr>
    <?php 
      $counter++;
      }
    } 
    ?>
    </tbody>
    
  </table>

  <!-- Pagination Controls -->
  <div id="pagination" class="pagination-container"></div>
</div>
<!-- Button to open the modal -->
<!-- Button to open the modal -->


<!-- Modal -->
<div class="modal-custom" id="teacherModal">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Select Teacher</h5>
      <button type="button" class="close" id="closeModalButton">&times;</button>
    </div>
    <div class="modal-body">
      <!-- Teacher Selection Dropdown -->
      <form method="post" action="assign_teacher.php">
        <div class="form-group">
          <label for="teacherSelect">Choose Teacher</label>
          <select class="form-control" id="teacherSelect" name="teacher_id">
            <option value="">Select a teacher</option>
            <?php
              $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
              // Fetch teachers from the database
              $sqlTeachers = "SELECT teacher_id, first_name, last_name FROM teacher";
              $stmtTeachers = $conn->prepare($sqlTeachers);
              $stmtTeachers->execute();
              $teachers = $stmtTeachers->fetchAll(PDO::FETCH_ASSOC);

              foreach ($teachers as $teacher) {
                echo "<option value='" . $teacher['teacher_id'] . "'>" . $teacher['first_name'] . " " . $teacher['last_name'] . "</option>";
              }
            ?>
          </select>
        </div>

        <!-- Table for Learners -->
        <div class="table-container">
          <table class="table-custom">
            <thead>
              <tr>
                <th>Select</th>
                <th>First Name</th>
                <th>Last Name</th>
              </tr>
            </thead>
            <tbody>
              <?php
                // Fetch learners with status = 'notassign'
                $sqlLearners = "SELECT learner_id, firstname, lastname FROM learner WHERE status = 'notassign'";
                $stmtLearners = $conn->prepare($sqlLearners);
                $stmtLearners->execute();
                $learners = $stmtLearners->fetchAll(PDO::FETCH_ASSOC);

                foreach ($learners as $learner) {
                  echo "<tr>
                          <td><input type='checkbox' name='learner_id[]' value='" . $learner['learner_id'] . "'></td>
                          <td>" . $learner['firstname'] . "</td>
                          <td>" . $learner['lastname'] . "</td>
                        </tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
        
        <button type="submit" class="btn-custom">Assign Teacher</button>
      </form>
    </div>
  </div>
</div>

<!-- CSS Styles for Modal -->
<style>
  /* Basic Button Style */
  
  .btn-custom:hover {
    background-color: #45a049;
  }

  /* Modal Overlay */
  .modal-custom {
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
  }

  .modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .modal-title {
    font-size: 20px;
    font-weight: bold;
  }

  .close {
    font-size: 24px;
    cursor: pointer;
  }

  .modal-body {
    margin-top: 15px;
  }

  /* Table Styling */
  .table-container {
    margin-top: 15px;
    max-height: 300px;
    overflow-y: auto;
  }

  .table-custom {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
  }

  .table-custom th, .table-custom td {
    padding: 8px;
    text-align: left;
    border: 1px solid #ddd;
  }

  .table-custom th {
    background-color: #f2f2f2;
    font-weight: bold;
  }

  /* Button Styling for Submit */
  .btn-custom {
    padding: 12px 25px;
    background-color: #007bff;
    color: white;
    border: none;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    display: block;
    width: 100%;
    margin-top: 15px;
  }

  .btn-custom:hover {
    background-color: #0056b3;
  }
</style>

<!-- JavaScript to Control Modal Display -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get the modal and buttons
    var modal = document.getElementById('teacherModal');
    var openButton = document.getElementById('openModalButton');
    var closeButton = document.getElementById('closeModalButton');

    // Open the modal
    openButton.addEventListener('click', function() {
      modal.style.display = 'flex';
    });

    // Close the modal
    closeButton.addEventListener('click', function() {
      modal.style.display = 'none';
    });

    // Close the modal when clicking outside of it
    window.addEventListener('click', function(event) {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  });
</script>



<script>
  
  document.addEventListener('DOMContentLoaded', function() {
    // Get the modal and the button that triggers it
    var modal = document.getElementById('teacherModal');
    var btn = document.querySelector('[data-toggle="modal"]');
    
    // When the user clicks the button, open the modal
    btn.onclick = function() {
      $(modal).modal('show');
    };
  });



  function print(){
    window.print();
  }
  const rowsPerPageSelect = document.getElementById('rowsPerPage');
  let rowsPerPage = parseInt(rowsPerPageSelect.value);
  let currentPage = 1;

  const rows = document.querySelectorAll('#attendanceTable tr');

  function paginateTable() {
    const totalRows = rows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);

    rows.forEach((row, index) => {
      row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? '' : 'none';
    });

    updatePagination(totalPages);
  }

  function updatePagination(totalPages) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    const prevButton = document.createElement('button');
    prevButton.textContent = 'Previous';
    prevButton.disabled = currentPage === 1;
    prevButton.classList.add('pagination-button');
    prevButton.onclick = () => changePage(currentPage - 1);
    paginationContainer.appendChild(prevButton);

    const nextButton = document.createElement('button');
    nextButton.textContent = 'Next';
    nextButton.disabled = currentPage === totalPages;
    nextButton.classList.add('pagination-button');
    nextButton.onclick = () => changePage(currentPage + 1);
    paginationContainer.appendChild(nextButton);
  }

  function changePage(page) {
    currentPage = page;
    paginateTable();
  }

  rowsPerPageSelect.addEventListener('change', function () {
    rowsPerPage = parseInt(this.value);
    currentPage = 1;
    paginateTable();
  });

  window.onload = paginateTable;

  // Dropdown Toggle
  function toggleDropdown(button) {
    const dropdownContent = button.nextElementSibling;
    const isActive = dropdownContent.classList.contains('active');
    
    // Hide all dropdowns
    document.querySelectorAll('.dropdown-content').forEach(content => content.classList.remove('active'));

    // If the dropdown wasn't already active, show it
    if (!isActive) {
        dropdownContent.classList.add('active');
    }
  }

  document.addEventListener('click', function (event) {
    if (!event.target.closest('.dropdown')) {
      document.querySelectorAll('.dropdown-content').forEach(content => content.classList.remove('active'));
    }
  });

  // Search Functionality
  const searchInput = document.getElementById('searchInput');

  searchInput.addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#attendanceTable tr');

    rows.forEach(row => {
      const rowData = row.innerText.toLowerCase();
      if (rowData.includes(searchValue)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });
</script>

</body>
</html>

<?php 
include("../includes/footer.php");


?>