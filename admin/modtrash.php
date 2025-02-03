<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/navbar.php");

$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

// Fetch all files from the database
$stmt = $conn->prepare("SELECT module_id, module_name, filetype FROM module WHERE mod_stats = 'remove'");
$stmt->execute();
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
      background-color: #4682B4;
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
</head>
<body>

<div class="container">
  <h1></h1>
  <a href="module.php" class="back-link" style="font-size: 30px">
    <i class="ri-arrow-left-line" style="margin-top: -40px;"></i> Modules Trash 
  </a>
  <hr>

  <?php if ($modules): ?>
    <table>
      <thead>
        <tr>
          <th>Icon</th>
          <th>Module Name</th>
         
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($modules as $module): ?>
          <tr>
            <td>
              <?php
              $filetype = strtolower($module['filetype']);
              if (strpos($filetype, 'pdf') !== false) {
                echo '<img src="../assets/img/pdf.png" alt="PDF">';
              } elseif (strpos($filetype, 'word') !== false || strpos($filetype, 'msword') !== false) {
                echo '<img src="../assets/img/word.png" alt="Word">';
              } elseif (strpos($filetype, 'presentation') !== false || strpos($filetype, 'ppt') !== false) {
                echo '<img src="../assets/img/ppt.png" alt="PowerPoint">';
              } else {
                echo '<img src="../assets/img/paper.png" alt="File">';
              }
              ?>
            </td>
            <td><?php echo htmlspecialchars($module['module_name']); ?></td>
            
            <td>
              <a href="modrestore.php?id=<?php echo $module['module_id']; ?>" class="action-btn">Restore</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No modules found.</p>
  <?php endif; ?>
</div>

</body>
</html>

<?php
include("../includes/footer.php");
?>
