<?php

include("../includes/header.php");
include("teachersidebar.php");
include("teacher_navbar.php");

$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");




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
      background-color: white;
      
    }

    th, td {
      padding: 10px;
      text-align: left;
      border: none;
    }

    th {
      background-color: #333;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #F5F5F5;
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

  </style>
</head>
<body>

<div class="table-containers">
  <div class="controls-container">

    <h1>Students</h1>
    <form method="POST" id="action-form" style="margin-left: auto;margin-right: 20px">
    <label style="margin-right: 10px">Select Status:</label>
    <select class="styled-select" name="action" onchange="this.form.submit()" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);background-color: white;border: none;padding: 5px">
        <option value="" hidden></option>
        <option value="all">All</option>
        <option value="inactive">Inactive</option>
        <option value="active">Active</option>
        
    </select>
</form>

 
    <div>
      <label for="rowsPerPage">Rows per page: </label>
      <select id="rowsPerPage" class="pagination-select" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);background-color: white;border: none;padding: 5px">
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="40">40</option>
        <option value="50">50</option>
      </select>
    </div>
  </div>

<?php 

    if(!isset($_POST['action'])){
      echo "Showing results: Active";
    } else{
       echo "Showing results:" .$selected = $_POST['action'];
    }

?>
  

  <input type="text" id="searchInput" class="search-bar" placeholder="Search table..." style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);margin-top: 10px">
  <table style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);">
    <thead>
      <tr>
        <th style="width: 15%">#</th>
        <th style="width: 23%">First</th>
        <th style="width: 23%">Last</th>
        <th style="width: 23%">Middle</th>
        <th style="width: 23%">Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="attendanceTable">
    <?php 

    if(!isset($_POST['action'])){
      $selected = "all";
    } else{
      $selected = $_POST['action'];
    }

    
    $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
  
    $id = $_SESSION['userid'];

$stmt = $conn->prepare("SELECT teacher_id FROM user WHERE user_id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

// Fetch the result
$teacher_id = $stmt->fetch(PDO::FETCH_ASSOC);
$idforteacher = $teacher_id['teacher_id'];

// Prepare the query based on the selected status
if ($selected == "all") {
    // Select learners based on teacher_id as well
    $sqll = $conn->prepare("SELECT * FROM learner WHERE teacher_id = :teacher_id");
    $sqll->bindParam(':teacher_id', $idforteacher, PDO::PARAM_INT);
    $sqll->execute();
} else {
    // Select learners based on status and teacher_id
    $sqll = $conn->prepare("SELECT * FROM learner WHERE status = :selected AND teacher_id = :teacher_id");
    $sqll->bindParam(':selected', $selected, PDO::PARAM_STR);
    $sqll->bindParam(':teacher_id', $idforteacher, PDO::PARAM_INT);
    $sqll->execute();
}

    

    // Execute the query
    

    // Fetch results
    $counter = 1;

    if ($sqll->execute()) {
      while ($students = $sqll->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo $counter; ?></td>
        <td><?php echo $students['firstname']; ?></td>
        <td><?php echo $students['lastname']; ?></td>
        <td style="text-align:left;"><?php echo $students['middlename']; ?></td>
        <td>
          <span class="status-badge 
            <?php echo ($students['status'] == 'active') ? 'status-active' : 'status-inactive'; ?>">
            <?php echo ucfirst($students['status']); ?>
          </span>
        </td>
        <td>
          <div class="dropdown">
            <button class="btn-edit" onclick="toggleDropdown(this)">
              <i class="ri-pencil-line"></i> Edit
            </button>
            <div class="dropdown-content">
              <a href="../admin/profileviewing.php?id=<?php echo $students['learner_id'] ?>"><button class="btn-view"><i class="ri-eye-line"></i> View</button></a>
              
              <button class="btn-inactive"><i class="ri-close-circle-line"></i> Mark as Inactive</button>
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
  <button class="btn-inactive" onclick="print()" style="border: none;background-color: white;float:right; margin-bottom: 10px;padding: 10px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);margin-top: 20px"><i class="ri-printer-fill"></i> print</button>

  <!-- Pagination Controls -->
  <div id="pagination" class="pagination-container"></div>
</div>

<script>
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