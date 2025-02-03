<?php
// Database connection details


try {
    // Create a PDO instance
    $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

    // Get the file ID from the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $fileId = $_GET['id'];

        // Fetch the file data by ID
        $stmt = $conn->prepare("SELECT module_name,filetype,  file_data FROM module WHERE module_id = :id");
        $stmt->bindParam(':id', $fileId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the file data
        $file = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($file) {
            // Set the appropriate headers
            header("Content-Type: " . $file['filetype']);
            
            header("Content-Disposition: attachment; filename=" . $file['filename']);

            // Output the file data to the browser
            echo $file['file_data']; // Serve the file for download
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
