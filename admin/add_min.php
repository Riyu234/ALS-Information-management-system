<?php
// Database connection (adjust with your own database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "system_als_data"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get admin details from form submission
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$email = $_POST['email'];

// Insert into admin table
$sql = "INSERT INTO admin (lastname, firstname, middlename, email) 
        VALUES ('$lastname', '$firstname', '$middlename', '$email')";

if ($conn->query($sql) === TRUE) {
    // Get the last inserted admin_id
    $admin_id = $conn->insert_id;
    
    // Get user details from form submission
    $username = $_POST['username'];
    $password = sha1($_POST['password']); // Hash password using SHA1
    $role = 'admin'; // You can set the role dynamically if needed
    
    // Insert into user table with the last generated admin_id
    $sql_user = "INSERT INTO user (username, password, role, admin_id) 
                 VALUES ('$username', '$password', '$role', '$admin_id')";
    
    if ($conn->query($sql_user) === TRUE) {
        echo "New record created successfully for both admin and user.";
    } else {
        echo "Error: " . $sql_user . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
