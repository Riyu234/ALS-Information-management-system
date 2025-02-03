<?php


try {
    // Create a PDO instance
     $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

    // Get the file ID from the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $fileId = $_GET['id'];

        // Fetch the file data by ID
        $stmt = $conn->prepare("SELECT module_name, filetype, file_data FROM module WHERE module_id = :id");
        $stmt->bindParam(':id', $fileId, PDO::PARAM_INT);
        $stmt->execute();

        $file = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($file) {
            // Set headers to display or download the file
            header("Content-Type: " . $file['filetype']);
            header("Content-Disposition: inline; filename=" . $file['module_name']);
            
            // Output the file data
            echo $file['file_data'];
        } else {
            echo "File not found.";
        }
    } else {
        echo "Invalid file ID.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
