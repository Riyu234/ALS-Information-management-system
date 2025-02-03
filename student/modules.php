<?php
session_start();
include("../includes/header.php");
include("studentsidebar.php");
include("../includes/navbar.php");

$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");


 
// Fetch all files from the database
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modules</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: #fff;">

<div style="width: 90%; margin: auto;">
  <h1 style="color: black;">Modules</h1>
  <hr style="background-color:#fff;margin-bottom: 20px">

  <!-- Add Module Form -->
  

  <!-- Grid container for modules -->
  <div class="grid">
      <?php

      $sqls = $conn->prepare("SELECT student_id from user where user_id=:ids");
        $sqls->bindParam(":ids", $_SESSION['userid']);
        $sqls->execute();

        $learner = $sqls->fetch(PDO::FETCH_ASSOC);

        $learner_id = $learner['student_id'];

        $quer2 = $conn->prepare("SELECT * FROM module_assigned WHERE learner_id = :id4");
        $quer2->bindParam(":id4", $learner_id);
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
        <div class="card">
          <div class="file-icon">
            <?php
            // Determine icon based on file type
            $filetype = strtolower($module['filetype']);
            if (strpos($filetype, 'pdf') !== false) {
              echo '<img src="icons/pdf-icon.png" alt="PDF" />';
            } elseif (strpos($filetype, 'word') !== false || strpos($filetype, 'msword') !== false) {
              echo '<img src="icons/word-icon.png" alt="Word" />';
            } elseif (strpos($filetype, 'presentation') !== false || strpos($filetype, 'ppt') !== false) {
              echo '<img src="icons/ppt-icon.png" alt="PowerPoint" />';
            } else {
              echo '<img src="icons/file-icon.png" alt="File" />';
            }
            ?>
          </div>
          <h3><?php echo htmlspecialchars($module['module_name']); ?></h3>
          
          <a href="../admin/view2.php?id=<?php echo $module['module_id']; ?>" class="btn">Open</a>
        </div>
      <?php 
    }
}
       ?>
    
  </div>
</div>

</body>
</html>



<style>
  /* Add Module Form */
  .add-module-container {
    margin-bottom: 30px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .add-module-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  .add-module-form h2 {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 10px;
  }

  .add-module-form label {
    font-size: 1rem;
    color: #666;
  }

  .add-module-form input[type="file"] {
    padding: 5px;
    font-size: 1rem;
    color: #333;
  }

  .btn-upload {
    padding: 10px 15px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
  }

  .btn-upload:hover {
    background-color: #45a049;
  }

  /* Grid layout similar to Google Drive */
  .grid {
    display: grid;
    gap: 20px;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    margin-top: 20px;
  }

  /* Card styles */
  .card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    transition: transform 0.2s;
  }

  .card:hover {
    transform: scale(1.05);
  }

  /* File icon styling */
  .file-icon img {
    max-width: 50px;
    margin-bottom: 10px;
  }

  .card h3 {
    font-size: 1rem;
    color: #333;
    margin: 10px 0;
  }

  .card p {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 10px;
  }

  .btn {
    display: inline-block;
    padding: 8px 12px;
    background-color: #4CAF50;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 0.9rem;
  }

  .btn:hover {
    background-color: #45a049;
  }
</style>

<?php 
include("../includes/footer.php");
?>
