<?php
$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id']; // Assume you pass the user's ID in the form.
    $newPassword = sha1($_POST['password']);


        // Update the password in the database
        $stmt = $conn->prepare("UPDATE user SET password = :password WHERE user_id = :user_id");
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        header("location:users.php");

        
} else{
    echo "<script>alert('no pasas')</script>";
}
?>
