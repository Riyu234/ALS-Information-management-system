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
  <title>Modules</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      width: 90%;
    }

    h1 {
      color: black;
      margin-top: 40px;
      margin-left: 40px;
    }

    table {
      width: 90%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      overflow: hidden;
      margin: auto;
    }

    table th, table td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    table th {
      background-color: gray;
      color: white;
    }

    table td img {
      max-width: 30px;
      margin-right: 10px;
    }

    table tr:hover {
      background-color: #f1f1f1;
    }

    .action-btn {
      padding: 10px 15px;
      background-color: #4682B4;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
    }

    .action-btn:hover {
      background-color: #1E90FF;
    }

    .back-link {
      text-decoration: none;
      color: black;
      font-size: 20px;
      margin-left: 40px;
    }

    .back-link i {
      position: relative;
      top: 3px;
    }
  </style>
  <script>
  function printCertificate(id) {
    // Update the current page's URL with the learner ID to show the print view
    const url = `page.php?id=${id}`;
    // This will reload the page and pass the learner ID to display the certificate content
    window.location.href = url;
  }
</script>

</head>
<body>

<div class="container">
  <a href="enroll.php" class="back-link" style="position: absolute; font-size: 30px; top:105px;">
     <i class="ri-arrow-left-line"></i>
  </a>
  
  <h1 style="margin-left: 80px">Certificate of Enrollment</h1>
  
  <hr>

  <table>
    <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Middle Name</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

      // Fetch all learners from the database
      $sqll = $conn->prepare("SELECT * FROM learner");
      $sqll->execute();
      while ($students = $sqll->fetch(PDO::FETCH_ASSOC)) {
        $id = htmlspecialchars($students['learner_id']);
        $firstname = htmlspecialchars($students['firstname']);
        $lastname = htmlspecialchars($students['lastname']);
        $middlename = htmlspecialchars($students['middlename']);
      ?>
        <tr>
          <td><?php echo $firstname; ?></td>
          <td><?php echo $lastname; ?></td>
          <td><?php echo $middlename; ?></td>
          <td>
            <button onclick="printCertificate('<?php echo $id; ?>')" class="action-btn">Print Certificate</button>
            <a href="admin_coedl.php?id=<?php echo $id?>" style="background-color: gray; color: white; padding: 12px;border-radius: 10px">Download</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php
include("../includes/footer.php");
?>
