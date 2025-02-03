<?php

include("../includes/header.php");
include("teachersidebar.php");
include("teacher_navbar.php");
$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>

        <style>
    .message-con {
        padding: 30px; /* This padding applies to the entire container */
        overflow: hidden; /* Prevent any unwanted overflow */
    }
    /* Styling for the message box */
    .message-box {
        border: 1px solid #ccc;
        padding: 15px; /* Padding inside the message box to keep content tight */
        margin-bottom: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        position: relative;
    }

    /* Read/unread status styling */
    .unread {
        background-color: #f9f9f9;
        font-weight: bold;
    }

    .read {
        background-color: #e0e0e0;
        color: gray;
    }

    /* Circle for unread status */
    .read-circle {
        width: 15px;
        height: 15px;
        background-color: red;
        border-radius: 50%;
        display: inline-block;
        position: absolute;
        right: 50px;
        top: 40%;
    }

    /* Button for marking all messages as read */
    .mark-read-btn {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    .mark-read-btn:hover {
        background-color: #45a049;
    }
</style>

    </style>
</head>
<body>
    <br>    <br>    
    <div style="padding: 50px; margin-top: 20px">
    <h2>Messages</h2>

   
        

        <?php
$learner = 10;

// Prepare the SQL query
$sqls = $conn->prepare("SELECT teacher_id FROM user WHERE user_id = :ids");

// Bind the parameter before executing
$sqls->bindParam(":ids", $_SESSION['userid'], PDO::PARAM_INT);

// Execute the query
$sqls->execute();

// Fetch the result
$learner = $sqls->fetch(PDO::FETCH_ASSOC);

// Ensure the result is valid before accessing it
if ($learner && isset($learner['teacher_id'])) {
    $learner_id = $learner['teacher_id'];


    $stmtss = $conn->prepare("SELECT * FROM teacher_message_status WHERE teacher_id = :learner_id ORDER BY message_id DESC");
$stmtss->bindParam(':learner_id', $learner_id);
$stmtss->execute();

$messages = $stmtss->fetchAll(PDO::FETCH_ASSOC);
} 
?>
<?php
    // Loop through all messages for the learner
    foreach ($messages as $message) {
        // Fetch message details from email_notification based on message_id
        $message_id = $message['message_id'];
        $message_status = $message['read_status'];

        // Query to fetch the message content and date
        $sqlss = $conn->prepare("SELECT * FROM email_notification WHERE message_id = :message_id");
        $sqlss->bindParam(':message_id', $message_id);
        $sqlss->execute();
        $message_details = $sqlss->fetch(PDO::FETCH_ASSOC);

        if ($message_details) {
            $message_content = $message_details['message'];
            $message_date = $message_details['message_date'];
            echo '<div class="message-con">';
            // Display the message with appropriate styling
            echo '<div class="message-box" class="' . ($message_status == 'unread' ? 'unread' : 'read') . '">';
            if ($message_status == 'unread') {
                // Display the red circle for unread messages
                echo '<span class="read-circle"></span>';
            }
            echo '<p style="' . ($message_status == 'unread' ? 'color:black' : 'color:gray') . '"><strong>Message:</strong> ' . htmlspecialchars($message_content) . '</p>';
            echo '<p style="' . ($message_status == 'unread' ? 'color:black' : 'color:gray') . '"><strong>Date:</strong> ' . htmlspecialchars($message_date) . '</p>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>

       <br> 
    <!-- Button to mark all messages as read -->
    <form method="post" action="mark_read.php">
        <a href="mark_read.php?id=<?php echo $learner_id; ?>" style="background-color: gray;padding: 10px;margin-top: 20px;color: white">Mark All as Read</a>
        
    </form>
</div>
</body>
</html>



<?php 
include("../includes/footer.php");
?>
    