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

    /* Responsive Design */
    @media (max-width: 768px) {
      .table-containers {
        padding: 10px;
        margin: 50px auto;
      }

      table {
        font-size: 12px;
      }

      th, td {
        padding: 8px;
      }

      .controls-container {
        flex-direction: column;
        align-items: flex-start;
      }

      h1 {
        font-size: 18px;
        margin-bottom: 10px;
      }

      .pagination-container {
        flex-direction: column;
        align-items: flex-start;
      }

      .pagination-select {
        margin-left: 0;
        margin-top: 10px;
      }

      .btn-edit {
        font-size: 14px;
        padding: 6px 12px;
      }

      .status-active, .status-inactive {
        font-size: 12px;
        padding: 4px 8px;
      }

      .search-bar {
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      table {
        font-size: 10px;
      }

      th, td {
        padding: 6px;
      }

      .controls-container {
        margin-bottom: 10px;
      }

      .pagination-container {
        flex-direction: column;
      }

      .pagination-button {
        font-size: 12px;
        padding: 4px 8px;
      }

      .search-bar {
        font-size: 12px;
        padding: 8px;
      }

      .btn-edit {
        font-size: 12px;
        padding: 4px 8px;
      }

      h1 {
        font-size: 16px;
      }
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
        <option value="notassign">Notassign</option>
        
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
  <input type="checkbox" id="selectAll" onclick="toggleSelectAll()"> Select All

  <input type="text" id="searchInput" class="search-bar" placeholder="Search table..." style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);margin-top: 10px">
  <table style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);">
    <thead>
      <tr>
        <th style="width: 5%">#</th>
        <th style="width: 23%">First</th>
        <th style="width: 23%">Last</th>
        <th style="width: 23%">Middle</th>
        <th style="width: 23%">Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <form action="print_students.php" method="POST">
    <tbody id="attendanceTable">
    <?php 

    if(!isset($_POST['action'])){
      $selected = "all";
    } else{
      $selected = $_POST['action'];
    }

    
    $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
  
    

    if($selected == "all"){
      $sqll = $conn->prepare("SELECT * FROM learner");
      $sqll->execute();


    
    }

    elseif ($selected == "notassign") {
      $sqll = $conn->prepare("SELECT * FROM learner WHERE status =:selected");
      $sqll->bindParam(':selected',$selected , PDO::PARAM_STR);
      $sqll->execute();    }

     else{
      $sqll = $conn->prepare("SELECT * FROM learner WHERE status =:selected");
      $sqll->bindParam(':selected',$selected , PDO::PARAM_STR);
      $sqll->execute();
    }
    

    // Execute the query
    

    // Fetch results
    $counter = 1;

    if ($sqll->execute()) {
      while ($students = $sqll->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo "<input type='checkbox' name='students[]' value='" . $students['learner_id'] . "' class='studentCheckbox' >" ?></td>
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
    <span 
    class="dropdown-trigger" 
    style="display: inline-block; padding: 5px 10px; background-color: #007bff; color: white; border-radius: 5px; cursor: pointer; text-align: center; font-size: 14px; font-weight: bold; text-decoration: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" 
    onclick="toggleDropdown(this)"
>
    <i class="ri-pencil-line"></i>Action
</span>
    <div class="dropdown-content">
        <a href="profileviewing.php?id=<?php echo $students['learner_id'] ?>"><i class="ri-eye-line"></i> View</a> <br>
        
    </div>
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
  <button type="submit" name="action" value="print" style="border: none;background-color: white;float:right; margin-bottom: 10px;padding: 10px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);margin-top: 20px"><i class="ri-printer-fill"></i> print</button>

  <!-- Pagination Controls -->
  <div id="pagination" class="pagination-container"></div>
</div>
</form>
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
  function toggleDropdown(trigger) {
    const dropdownContent = trigger.nextElementSibling;
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

  function toggleSelectAll() {
            var isChecked = document.getElementById('selectAll').checked;
            var checkboxes = document.querySelectorAll('.studentCheckbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        }

</script>

</body>
</html>

<?php 
include("../includes/footer.php");


?>