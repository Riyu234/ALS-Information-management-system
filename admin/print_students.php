<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'print') {
        $students = $_POST['students'] ?? [];

        if (empty($students)) {
            echo "Please select at least one student.<br>";
            exit;
        } else {
            // Connect to the database to fetch student details
            try {
                $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Prepare and execute query to fetch students' details
                $in  = str_repeat('?,', count($students) - 1) . '?';
                $sql = "SELECT learner_id, firstname, lastname,middlename, status FROM learner WHERE learner_id IN ($in)";
                $stmt = $conn->prepare($sql);
                $stmt->execute($students);
                $studentDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<script>window.print()</script>";

                // If no students found, exit
                if (!$studentDetails) {
                    echo "No students found.<br>";
                    exit;
                }

                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Printable Student List</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }
                        .print-container {
                            width: 100%;
                            max-width: 800px;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #ddd;
                            border-radius: 10px;
                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                            background-color: #f9f9f9;
                        }
                        h2 {
                            text-align: center;
                            margin-bottom: 10px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 20px 0;
                        }
                        table th, table td {
                            border: 1px solid #ddd;
                            text-align: left;
                            padding: 8px;
                        }
                        table th {
                            background-color: #f4f4f4;
                        }
                        .print-button {
                            display: inline-block;
                            margin-top: 20px;
                            padding: 10px 20px;
                            background-color: #007bff;
                            color: #fff;
                            text-decoration: none;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                        }
                        .print-button:hover {
                            background-color: #0056b3;
                        }

                        /* Print-Only Styling */
                        @media print {
                            body * {
                                visibility: hidden; /* Hide everything */
                            }
                            .print-container, .print-container * {
                                visibility: visible; /* Only show print-container */
                            }
                            .print-container {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                margin: 0;
                                padding: 0;
                                box-shadow: none; /* Remove shadow in print */
                                border: none; /* Remove border in print */
                            }
                            .print-button {
                                display: none; /* Hide print button in print view */
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="print-container">
                        <h2>Students</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 10%">Student ID</th>
                                    <th style="width: 50%">Student Name</th>
                                    <th style="width: 20%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($studentDetails as $student): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($student['learner_id']) ?></td>
                                        <td><?= htmlspecialchars(ucfirst($student['firstname'])) . ' ' . htmlspecialchars(ucfirst($student['lastname'])) . ' ' . htmlspecialchars(ucfirst($student['middlename'])) ?></td>
                                        <td><?= htmlspecialchars($student['status']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button class="print-button" onclick="window.print()">Print List</button>
                    </div>
                </body>
                </html>
                <?php
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
?>
<script>
        // Listen for beforeprint event (when print dialog is about to open)
        

        // Listen for afterprint event (when print dialog is closed)
        window.onafterprint = function () {
            window.location.href = "student.php";
            
        };
    </script>