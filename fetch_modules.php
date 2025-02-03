<?php
$connect = new PDO("mysql:dbname=als_database;host=localhost", "root", "");

try {
    // Prepare a query to fetch all modules
    $stmt = $conn->prepare("SELECT * FROM modules");
    $stmt->execute();
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the modules as a JSON response
    echo json_encode($modules);
} catch (PDOException $e) {
    echo "Error fetching modules: " . $e->getMessage();
}
?>
