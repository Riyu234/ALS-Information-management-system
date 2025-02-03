<?php
$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

// Assume $teacher_id contains the teacher's ID
$teacher_id = $_GET['id'];

$sql = "UPDATE teacher_message_status
        SET read_status = 'read'
        WHERE teacher_id = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $teacher_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "Read status updated successfully.";
} else {
    echo "Failed to update read status.";
}
?>
