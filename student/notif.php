<?php
session_start();
include("../includes/header.php");
include("studentsidebar.php");
include("../includes/navbar.php");
$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

$sqls = $conn->prepare("SELECT student_id FROM user WHERE user_id = :ids");
$sqls->bindParam(":ids", $_SESSION['userid']);
$sqls->execute();

$learner = $sqls->fetch(PDO::FETCH_ASSOC);

$learner_id = $learner['student_id'];

$_SESSION['learner_id'] = $learner['student_id'];   // Example learner_id, this would be dynamic in a real application

// Query to fetch all messages for the specific learner, ordered by message_id descending
$stmtss = $conn->prepare("SELECT * FROM learner_message_status WHERE learner_id = :learner_id ORDER BY message_id DESC");
$stmtss->bindParam(':learner_id', $learner_id);
$stmtss->execute();

// Fetch all messages for the learner
$messages = $stmtss->fetchAll(PDO::FETCH_ASSOC);

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
    <div style="padding: 50px; margin-top: 20px">
    <h2>Messages</h2>

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

    <!-- Button to mark all messages as read -->
    <form method="post" action="clear.php">
        <button type="submit" class="mark-read-btn" name="buton">Mark All as Read</button>
        <input type="hidden" name="learner_id" value="<?php echo $learner_id; ?>">
    </form>
</div>
</body>
</html>



<?php 
include("../includes/footer.php");
?>
