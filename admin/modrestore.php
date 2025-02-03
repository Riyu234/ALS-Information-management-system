<?php


try {
    // Create a PDO instance
     $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
     $remove = "notremove";
    // Get the file ID from the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $fileId = $_GET['id'];

        // Fetch the file data by ID
        $stmt = $conn->prepare("UPDATE module SET mod_stats= :remove WHERE module_id = :id");
        $stmt->bindParam(':remove', $remove);
        $stmt->bindParam(':id', $fileId, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Restore Successfully')</script>";
        header("location:modtrash.php");
        


        
        
    } else {
        echo "Invalid file ID.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
