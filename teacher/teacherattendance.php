<?php 




include("../includes/header.php");
include("teachersidebar.php");
include("teacher_navbar.php");

if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit();
}





// Check if the user is authenticated


$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

// Check if the attendance data is submitted when the save button is clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn']) && isset($_POST['attendance'])) {
  $currentDate = date('Y-m-d'); // Get the current date

  // Check if attendance for the current date already exists
  $checkQuery = $conn->prepare("SELECT COUNT(*) FROM attendance WHERE DATE(attendance_date) = :currentDate");
  $checkQuery->bindParam(':currentDate', $currentDate);
  $checkQuery->execute();

  $attendanceExists = $checkQuery->fetchColumn() > 0;

  if ($attendanceExists) {
      echo "<script>alert('Attendance for today has already been saved.');</script>";
  } else {
      $attendanceData = $_POST['attendance'];

      foreach ($attendanceData as $key => $data) {
          $learner_id = $data['learner_id'];
          $teacher_id = $data['teacher_id'];
          $status = $data['status'];

          // Insert attendance into the database
          $stmt = $conn->prepare("INSERT INTO attendance (learner_id, teacher_id, attendance_date, status) VALUES (:learner_id, :teacher_id, NOW(), :status)");
          $stmt->bindParam(':learner_id', $learner_id);
          $stmt->bindParam(':teacher_id', $teacher_id);
          $stmt->bindParam(':status', $status);

          if (!$stmt->execute()) {
              echo "Error saving attendance for learner {$learner_id}.";
          }
      }

      // Success message
      echo "<script>alert('Attendance saved successfully.');</script>";
  }
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Custom Attendance Table</title>
  <style>
    .table-containers {
      width: 95%;
      margin-top: 80px;
      margin-left: 20px;
      
      padding: 20px 20px 50px 20px;
    }

    .search-bar {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .btn-view-attendance {
      display: inline-block;
      padding: 10px 20px;
      background-color: white;
      color: black;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-bottom: 10px;
      float: right;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);
    }

    h1 {
      display: inline-block;
    }

    .btn-view-attendance:hover {
      background-color: #555;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border: 1px solid #ddd;
    }

    th {
      background-color: #333;
      color: white;
    }

    th:nth-child(5), td:nth-child(5) {
      width: 100px; /* Further reduced the Action column size */
      text-align: center;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .radio-group {
      display: flex;
      justify-content: space-between; /* Align items horizontally with equal spacing */
      gap: 5px; /* Add spacing between labels */
    }

    .radio-group label {
      display: flex;
      align-items: center; /* Vertically align text and radio buttons */
      font-size: 12px; /* Reduce font size for compactness */
    }

    .radio-group input {
      margin-right: 5px;
    }
  </style>
</head>
<body>

<div class="table-containers">
  <h1><i class="ri-survey-fill"></i> Attendance</h1>
  <a href="test.php"><button class="btn-view-attendance"><i class="ri-file-list-2-fill"></i> View Attendance</button></a>
  
  <input type="text" id="searchInput" class="search-bar" placeholder="Search table..." style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);">

  <form  method="post">
    <table style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);">
      <thead>
        <tr>
          <th>#</th>
          <th>First</th>
          <th>Last</th>
          <th>Middle</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="attendanceTable">
      <?php 
      
      
      $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

      $sqls = $conn->prepare("SELECT teacher_id FROM user WHERE user_id = :ids");
      $sqls->bindParam(":ids", $_SESSION['userid']);
      $sqls->execute();

      $teacher = $sqls->fetch(PDO::FETCH_ASSOC);

      $teacher_id = $teacher['teacher_id']; // Get teacher_id

      // Now, fetch learners based on the teacher_id
      $sqll = $conn->prepare("SELECT * FROM learner WHERE teacher_id = :teacher_id");
      $sqll->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
      $sqll->execute();

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
            <div class="radio-group">
              <label for="present<?php echo $counter; ?>">
                <input type="radio" id="present<?php echo $counter; ?>" name="attendance[<?php echo $counter; ?>][status]" value="Present" required> Present
              </label>
              <label for="absent<?php echo $counter; ?>">
                <input type="radio" id="absent<?php echo $counter; ?>" name="attendance[<?php echo $counter; ?>][status]" value="Absent"> Absent
              </label>
              <input type="hidden" name="attendance[<?php echo $counter; ?>][learner_id]" value="<?php echo $students['learner_id']; ?>">
              <input type="hidden" name="attendance[<?php echo $counter; ?>][teacher_id]" value="<?php echo $teacher_id; ?>">
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
    <button type="submit" style="float:right;margin-top:10px;border: none;background-color: white;padding: 10px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);" name="btn">Save attendance</button>
  </form>
</div>

<script>
  const searchInput = document.getElementById('searchInput');
  const table = document.getElementById('attendanceTable');
  
  searchInput.addEventListener('keyup', function () {
    const filter = searchInput.value.toLowerCase();
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
      const cells = rows[i].getElementsByTagName('td');
      let match = false;

      for (let j = 0; j < cells.length; j++) {
        if (cells[j].innerText.toLowerCase().includes(filter)) {
          match = true;
          break;
        }
      }

      rows[i].style.display = match ? '' : 'none';
    }
  });
</script>
<?php 
include("../includes/footer.php");
?>  

</body>
</html>
