<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "riosdata";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Get POST values
$email = $_POST['email'];
$password = $_POST['password']; // Plain text from the app

// Hash the incoming password using SHA1
$hashedPassword = sha1($password);

// Validate user
$sql = "SELECT * FROM customers WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($hashedPassword === $user['password']) { // Compare hashed passwords
        // Login successful
        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "data" => [
                "customer_id" => $user['customer_id'],
                "first_name" => $user['first_name'],
                "last_name" => $user['last_name'],
                "email" => $user['email']
            ]
        ]);
    } else {
        // Invalid password
        echo json_encode(["success" => false, "message" => "Invalid email or password"]);
    }
} else {
    // User not found
    echo json_encode(["success" => false, "message" => "User not found"]);
}

// Close connection
$stmt->close();
$conn->close();
