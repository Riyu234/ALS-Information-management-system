<?php

include("../includes/header.php");
include("teachersidebar.php");
include("teacher_navbar.php");

$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

// Fetch all files from the database
$stmt = $conn->prepare("SELECT module_id, module_name, filetype FROM module WHERE mod_stats != 'remove'");
$stmt->execute();
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modules</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body >

<div style="width: 90%; margin: auto;">
  <div style="display: flex; justify-content: space-between;"> 
     <h1 style="color: black;margin-top: 100px">Modules</h1>
    
  
  </div>
 
  <hr style="background-color:#fff;margin-bottom: 20px">
  

  <!-- Add Module Form -->
  

  <!-- Grid container for modules -->
  <div class="grid">
    <div class="add-module-container" style="width: 220PX;display: none">
    <form action="" method="POST" enctype="multipart/form-data" class="add-module-form" style="text-align: c">
      <h2>Add Module</h2>
      
      <input type="file"  name="file" id="file" required style="border: solid 1px gray;">
      <button type="submit" name="submit" class="btn-upload">Upload</button>
    </form>
  </div>
    <?php if ($modules): ?>
      <?php foreach ($modules as $module): ?>
        <div class="card" style="width: 220PX">
          <div class="file-icon">
            <?php
            // Determine icon based on file type
            $filetype = strtolower($module['filetype']);
            if (strpos($filetype, 'pdf') !== false) {
              echo '<img src="../assets/img/pdf.png" alt="PDF" />';
            } elseif (strpos($filetype, 'word') !== false || strpos($filetype, 'msword') !== false) {
              echo '<img src="../assets/img/word.png" alt="Word" />';
            } elseif (strpos($filetype, 'presentation') !== false || strpos($filetype, 'ppt') !== false) {
              echo '<img src="../assets/img/ppt.png" alt="PowerPoint" />';
            } else {
              echo '<img src="../assets/img/paper.png" alt="File" />';
            }
            ?>
          </div class="abni">
          <h3><?php echo htmlspecialchars($module['module_name']); ?></h3>
          <div style="display: flex; justify-content: space-around;gap:10px;"> 
            <a href="../admin/view2.php?id=<?php echo $module['module_id']; ?>" class="" style="background-color: #4682B4;padding: 10px;width: 50%;border-radius: 10px;color:white">Open</a><a href="removemod.php?id=<?php echo $module['module_id']; ?>" class="" style="background-color: lightgray;padding: 10px;width: 50%;border-radius: 10px;color:white">Delete</a>
          </div>

          <style type="">
            .abni a{
                
                text-align: center;
                background-color: gray;
            }
          </style>
          
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No modules found.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>

<?php

if (isset($_POST['submit'])) {
    $display = false;

    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $display = true;
        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
        $fileData = file_get_contents($_FILES['file']['tmp_name']); // Read the file content

        // Check if the file already exists in the database
        $stmt = $conn->prepare("SELECT COUNT(*) FROM module WHERE module_name = :module_name");
        $stmt->bindParam(':module_name', $fileName);
        $stmt->execute();
        $fileExists = $stmt->fetchColumn() > 0;

        if ($fileExists) {
            // File already exists
            echo "<script>alert('File already exists in the database.');</script>";
        } else {
            // Prepare SQL to insert the file
            $stmt = $conn->prepare("INSERT INTO module (module_name, filetype, file_data) VALUES (:module_name, :filetype, :file_data)");
            $stmt->bindParam(':module_name', $fileName);
            $stmt->bindParam(':filetype', $fileType);
            $stmt->bindParam(':file_data', $fileData, PDO::PARAM_LOB); // Bind the binary data as LOB

            // Execute the query
            if ($stmt->execute()) {
                echo "<script>alert('File uploaded successfully!'); window.location.href = '';</script>";
            } else {
                echo "<script>alert('Failed to upload file.');</script>";
            }
        }
    } else {
        echo "<script>alert('No file uploaded or an error occurred.');</script>";
    }
}
?>


<style>
  /* Add Module Form */
  .add-module-container {
    margin-bottom: 30px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100px;
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
    background-color: #4682B4;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
  }

  .btn-upload:hover {
    background-color: #1E90FF;
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
  input[type="file"] {
         display: inline-block;
            padding: 10px 20px;
            cursor: pointer;
            background-color: lightgray;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
</style>

<?php 
include("../includes/footer.php");
?>
