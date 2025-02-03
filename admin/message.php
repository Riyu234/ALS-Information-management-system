<?php




include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/navbar.php");


?>

<!DOCTYPE html>
<html>
<head>
  <title>Send Message</title>
</head>
<body >
  <div class="messagecon">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <h1>Messages</h1>
      <button id="openModal" style="width: 120px;font-size: 18px;height: 35px;background-color: #fff;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06); border: none"><i class="ri-history-line"></i> History</button>
    </div>
    <hr>
    <form action="" method="post" style="display: flex; flex-direction: column;" class="ee">
      <h2>Create Message</h2>
      <p>Select recipient</p>
      <select style="width: 20%;height: 35px; margin-bottom: 20px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);border: none;padding: 10px" name="exampleSelect" >
        <option value="allstudents">All Students</option>
        <option value="allteachers">All Teachers</option>
      </select>
      <input type="text" placeholder="Subject" name="subject" required style="height: 40px;overflow-y:scroll;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);border: solid 1px lightgray;padding: 10px" >
      <textarea placeholder="Message" name="message" required style="height:100px;width: 50%;margin-bottom: 50px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);border: solid 1px lightgray;padding: 10px"></textarea>
      <input type="email" placeholder="Sender Email" name="sender" required style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);border: solid 1px lightgray;padding: 10px">
      <button name="btn"  style="width: 10%;border: none;background-color: gray;color: white;height: 40px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);border: none;padding: 10px">Send</button>
    </form>
  </div>
  <div class="weird-modal" id="messageModal">
        <div class="weird-modal-content">
            <div class="weird-modal-header">
                Message History
                <span class="weird-modal-close" id="closeModal">&times;</span>
            </div>
            <ul class="weird-message-list">
                <?php
                // Establish connection using PDO
                $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

                // Fetch all messages, ordered by latest date first
                $query = $conn->prepare("SELECT * FROM email_notification ORDER BY message_date DESC");
                $query->execute();

                // Loop through each message
                while ($messages = $query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <li class="weird-message-item">
                    <div>
                        <div class="weird-message-sender"><?php echo htmlspecialchars($messages['who']); ?></div>
                        <div class="weird-message-content"><?php echo htmlspecialchars($messages['message']); ?></div>
                    </div>
                    <div>
                        <div class="weird-message-time"><?php echo htmlspecialchars($messages['message_date']); ?></div>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>

  
</body>
</html>


<?php 

$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../vendor/phpmailer/phpmailer/src/Exception.php';

if (isset($_POST['btn'])) {
    $mail = new PHPMailer(true);
    $selectedOption = $_POST['exampleSelect'];

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'riocagapevillasana04@gmail.com'; // Your Gmail address
        $mail->Password = 'tnng wysn hppt gndy'; // Your Gmail App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Set up sender information
        $mail->setFrom($_POST['sender'], 'ALS Binalbagan');
        
        // Handling recipients based on selected option
        if ($selectedOption == "allstudents") {
            $query = $conn->query("SELECT email FROM learner");
            foreach ($query as $row) {
                $mail->addAddress($row['email']); // Recipient's email address
                $mail->Subject = $_POST['subject'];
                $mail->Body = $_POST['message'];

                // Send email and check for success
                if (!$mail->send()) {
                    echo "Failed to send email to {$row['email']}. Error: {$mail->ErrorInfo}";
                    break;
                }
            }
            echo "Emails sent successfully to all students!";
        } elseif ($selectedOption == "allteachers") {
            $query = $conn->query("SELECT email FROM teacher");
            foreach ($query as $row) {
                $mail->addAddress($row['email']); // Recipient's email address
                $mail->Subject = $_POST['subject'];
                $mail->Body = $_POST['message'];

                // Send email and check for success
                if (!$mail->send()) {
                    echo "Failed to send email to {$row['email']}. Error: {$mail->ErrorInfo}";
                    break;
                }
            }
            echo "Emails sent successfully to all teachers!";
        } else {
            echo "Invalid selection. Please choose a valid recipient group.";
        }
        
    } catch (Exception $e) {
        echo "Failed to send email. Error: {$mail->ErrorInfo}";
    }


$currentDate = date('Y-m-d');

// Prepare the SQL query to insert the message into email_notification
$sqlss = $conn->prepare("INSERT INTO email_notification (who, message, message_date) VALUES (:who, :message, :message_date)");

// Bind parameters
$sqlss->bindParam(':who', $selectedOption);
$sqlss->bindParam(':message', $_POST['message']);
$sqlss->bindParam(':message_date', $currentDate);

// Execute the query
if ($sqlss->execute()) {
    // Get the last inserted message_id
    $message_id = $conn->lastInsertId();

    // Check if selectedOption is "allstudents" or "allteachers"
    if ($selectedOption == "allstudents") {
        // Insert the message for all learners (students)
        $stmt = $conn->prepare("SELECT learner_id FROM learner");
        $stmt->execute();

        // Loop through all learners and insert the message status for each learner
        while ($learner = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $learner_id = $learner['learner_id'];
            
            // Prepare the insert query for learner_message_status
            $insertStatus = $conn->prepare("INSERT INTO learner_message_status (learner_id, message_id, read_status) VALUES (:learner_id, :message_id, 'unread')");
            $insertStatus->bindParam(':learner_id', $learner_id);
            $insertStatus->bindParam(':message_id', $message_id);
            $insertStatus->execute();
        }

    } elseif ($selectedOption == "allteachers") {
        // Insert the message for all teachers
        $stmt = $conn->prepare("SELECT teacher_id FROM teacher"); // Assuming you have a teacher table
        $stmt->execute();

        // Loop through all teachers and insert the message status for each teacher
        while ($teacher = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $teacher_id = $teacher['teacher_id'];
            
            // Prepare the insert query for learner_message_status (assuming teacher_id is treated similarly to learner_id)
            $insertStatus = $conn->prepare("INSERT INTO teacher_message_status (teacher_id, message_id, read_status) VALUES (:teacher_id, :message_id, 'unread')");
            $insertStatus->bindParam(':teacher_id', $teacher_id);  // Using learner_id to store teacher_id (adjust as needed)
            $insertStatus->bindParam(':message_id', $message_id);
            $insertStatus->execute();
        }
    }

    // Alert for successful message sending
    echo "<script>alert('Message sent successfully to " . $selectedOption . ".');</script>";
} else {
    // If message insertion fails
    echo "<script>alert('Failed to send the message.');</script>";
}


}


?>

<style type="text/css">
  .messagecon{
    margin: 100px auto;
    width: 90%;
    padding:20px;
  }
  .ee input{
    width: 40%;
    margin-bottom: 20px;
    border: solid 1px gray;
  }

   .weird-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            margin-top: 40px;

        }
        .weird-modal.active {
            display: flex;
        }
        .weird-modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            overflow-y: auto;
            max-height: 80%;
        }
        .weird-modal-header {
            background: #4CAF50;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            border-radius: 10px 10px 0 0;
        }
        .weird-modal-close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
        }
        .weird-message-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .weird-message-item {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
        }
        .weird-message-item:last-child {
            border-bottom: none;
        }
        .weird-message-sender {
            font-weight: bold;
            color: #333;
        }
        .weird-message-time {
            font-size: 12px;
            color: #888;
        }
        .weird-message-content {
            margin-top: 5px;
            color: #555;
        }
</style>

 <script>
        // Modal Script
        const modal = document.getElementById("messageModal");
        const openModal = document.getElementById("openModal");
        const closeModal = document.getElementById("closeModal");

        // Open Modal
        openModal.addEventListener("click", () => {
            modal.classList.add("active");
        });

        // Close Modal
        closeModal.addEventListener("click", () => {
            modal.classList.remove("active");
        });

        // Close Modal when clicking outside of content
        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.classList.remove("active");
            }
        });
    </script>

<?php include("../includes/footer.php"); ?>
