<?php
$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
$learner_id = $_POST['learner_id'];

$sql = "UPDATE learner_message_status 
            SET read_status = 'read' 
            WHERE learner_id = :learner_id AND read_status = 'unread'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':learner_id', $learner_id);

    if ($stmt->execute()) {
        // Redirect back to the message page
        header("Location: notif.php?learner_id=$learner_id&status=success");

        exit;
    } else {
        echo "Error updating messages as read.";
    }

 ?>