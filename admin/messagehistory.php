<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message History</title>
    <style>
        /* Modal Styles */
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
</head>
<body>
    <button id="openModal" style="margin: 20px;">View Messages</button>

    <!-- Modal Structure -->
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
</body>
</html>
