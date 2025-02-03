<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted data
    $selectedTeacherId = isset($_POST['selected_teacher_id']) ? htmlspecialchars($_POST['selected_teacher_id']) : null;
    $getId = isset($_POST['get_id']) ? htmlspecialchars($_POST['get_id']) : null;

    if ($selectedTeacherId && $getId) {
        try {
            // Database connection
            $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query 1: Update `class_facilitator`
            $query1 = "UPDATE class_facilitator SET teacher_id = :teacher_id WHERE learner_id = :learner_id";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(':teacher_id', $selectedTeacherId, PDO::PARAM_STR);
            $stmt1->bindParam(':learner_id', $getId, PDO::PARAM_STR);
            $stmt1->execute();

            // Query 2: Update `learner`
            $query2 = "UPDATE learner SET teacher_id = :teacher_id WHERE learner_id = :learner_id";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bindParam(':teacher_id', $selectedTeacherId, PDO::PARAM_STR);
            $stmt2->bindParam(':learner_id', $getId, PDO::PARAM_STR);
            $stmt2->execute();

            // Success message
            echo "<h2>Successfully Updated Records:</h2>";
            echo "<p><strong>Updated Teacher ID:</strong> $selectedTeacherId</p>";
            echo "<p><strong>Target Learner ID:</strong> $getId</p>";
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Invalid data. Please ensure both a teacher and learner ID are provided.</p>";
    }
} else {
    echo "<p>Invalid request. Please use the form to submit data.</p>";
}
?>
